<?php

declare (strict_types=1);
namespace ConfigTransformer2021061810\Symplify\PhpConfigPrinter\NodeFactory\Service;

use ConfigTransformer2021061810\PhpParser\Node\Arg;
use ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021061810\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use ConfigTransformer2021061810\Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory\TagsServiceOptionKeyYamlToPhpFactory;
use ConfigTransformer2021061810\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer2021061810\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\SymfonyVersionFeature;
use ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class AutoBindNodeFactory
{
    /**
     * @var string
     */
    public const TYPE_SERVICE = 'service';
    /**
     * @var string
     */
    public const TYPE_DEFAULTS = 'defaults';
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface
     */
    private $symfonyVersionFeatureGuard;
    /**
     * @var \Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory\TagsServiceOptionKeyYamlToPhpFactory
     */
    private $tagsServiceOptionKeyYamlToPhpFactory;
    public function __construct(\ConfigTransformer2021061810\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \ConfigTransformer2021061810\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer2021061810\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface $symfonyVersionFeatureGuard, \ConfigTransformer2021061810\Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory\TagsServiceOptionKeyYamlToPhpFactory $tagsServiceOptionKeyYamlToPhpFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->symfonyVersionFeatureGuard = $symfonyVersionFeatureGuard;
        $this->tagsServiceOptionKeyYamlToPhpFactory = $tagsServiceOptionKeyYamlToPhpFactory;
    }
    /**
     * Decorated node with:
     * ->autowire()
     * ->autoconfigure()
     * ->bind()
     */
    public function createAutoBindCalls(array $yaml, \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall $methodCall, string $type) : \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall
    {
        foreach ($yaml as $key => $value) {
            if ($key === \ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOWIRE) {
                $methodCall = $this->createAutowire($value, $methodCall, $type);
            }
            if ($key === \ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOCONFIGURE) {
                $methodCall = $this->createAutoconfigure($value, $methodCall, $type);
            }
            if ($key === \ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PUBLIC) {
                $methodCall = $this->createPublicPrivate($value, $methodCall, $type);
            }
            if ($key === \ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey::BIND) {
                $methodCall = $this->createBindMethodCall($methodCall, $yaml[\ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey::BIND]);
            }
            if ($key === \ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey::TAGS) {
                $methodCall = $this->createTagsMethodCall($methodCall, $value);
            }
        }
        return $methodCall;
    }
    private function createBindMethodCall(\ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall $methodCall, array $bindValues) : \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall
    {
        foreach ($bindValues as $key => $value) {
            $args = $this->argsNodeFactory->createFromValues([$key, $value]);
            $methodCall = new \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall($methodCall, \ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey::BIND, $args);
        }
        return $methodCall;
    }
    private function createAutowire($value, \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall $methodCall, string $type) : \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall
    {
        if ($value === \true) {
            return new \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall($methodCall, \ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOWIRE);
        }
        // skip default false
        if ($type === self::TYPE_DEFAULTS) {
            return $methodCall;
        }
        $args = [new \ConfigTransformer2021061810\PhpParser\Node\Arg($this->commonNodeFactory->createFalse())];
        return new \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall($methodCall, \ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOWIRE, $args);
    }
    private function createAutoconfigure($value, \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall $methodCall, string $type) : \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall
    {
        if ($value === \true) {
            return new \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall($methodCall, \ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOCONFIGURE);
        }
        // skip default false
        if ($type === self::TYPE_DEFAULTS) {
            return $methodCall;
        }
        $args = [new \ConfigTransformer2021061810\PhpParser\Node\Arg($this->commonNodeFactory->createFalse())];
        return new \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall($methodCall, \ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOCONFIGURE, $args);
    }
    private function createPublicPrivate($value, \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall $methodCall, string $type) : \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall
    {
        if ($value !== \false) {
            return new \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall($methodCall, 'public');
        }
        // default value
        if ($type === self::TYPE_DEFAULTS) {
            if ($this->symfonyVersionFeatureGuard->isAtLeastSymfonyVersion(\ConfigTransformer2021061810\Symplify\PhpConfigPrinter\ValueObject\SymfonyVersionFeature::PRIVATE_SERVICES_BY_DEFAULT)) {
                return $methodCall;
            }
            return new \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall($methodCall, 'private');
        }
        $args = [new \ConfigTransformer2021061810\PhpParser\Node\Arg($this->commonNodeFactory->createFalse())];
        return new \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall($methodCall, 'public', $args);
    }
    private function createTagsMethodCall(\ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall $methodCall, $value) : \ConfigTransformer2021061810\PhpParser\Node\Expr\MethodCall
    {
        return $this->tagsServiceOptionKeyYamlToPhpFactory->decorateServiceMethodCall(null, $value, [], $methodCall);
    }
}
