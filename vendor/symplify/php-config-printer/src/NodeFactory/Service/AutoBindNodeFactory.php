<?php

declare (strict_types=1);
namespace ConfigTransformer202108114\Symplify\PhpConfigPrinter\NodeFactory\Service;

use ConfigTransformer202108114\PhpParser\Node\Arg;
use ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202108114\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
use ConfigTransformer202108114\Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory\TagsServiceOptionKeyYamlToPhpFactory;
use ConfigTransformer202108114\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202108114\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer202108114\Symplify\PhpConfigPrinter\ValueObject\SymfonyVersionFeature;
use ConfigTransformer202108114\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
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
    public function __construct(\ConfigTransformer202108114\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \ConfigTransformer202108114\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer202108114\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface $symfonyVersionFeatureGuard, \ConfigTransformer202108114\Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory\TagsServiceOptionKeyYamlToPhpFactory $tagsServiceOptionKeyYamlToPhpFactory)
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
    public function createAutoBindCalls(array $yaml, \ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall $methodCall, string $type) : \ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall
    {
        foreach ($yaml as $key => $value) {
            if ($key === \ConfigTransformer202108114\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOWIRE) {
                $methodCall = $this->createAutowire($value, $methodCall, $type);
            }
            if ($key === \ConfigTransformer202108114\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOCONFIGURE) {
                $methodCall = $this->createAutoconfigure($value, $methodCall, $type);
            }
            if ($key === \ConfigTransformer202108114\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PUBLIC) {
                $methodCall = $this->createPublicPrivate($value, $methodCall, $type);
            }
            if ($key === \ConfigTransformer202108114\Symplify\PhpConfigPrinter\ValueObject\YamlKey::BIND) {
                $methodCall = $this->createBindMethodCall($methodCall, $yaml[\ConfigTransformer202108114\Symplify\PhpConfigPrinter\ValueObject\YamlKey::BIND]);
            }
            if ($key === \ConfigTransformer202108114\Symplify\PhpConfigPrinter\ValueObject\YamlKey::TAGS) {
                $methodCall = $this->tagsServiceOptionKeyYamlToPhpFactory->decorateServiceMethodCall(null, $value, [], $methodCall);
            }
        }
        return $methodCall;
    }
    private function createBindMethodCall(\ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall $methodCall, array $bindValues) : \ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall
    {
        foreach ($bindValues as $key => $value) {
            $args = $this->argsNodeFactory->createFromValues([$key, $value]);
            $methodCall = new \ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall($methodCall, \ConfigTransformer202108114\Symplify\PhpConfigPrinter\ValueObject\YamlKey::BIND, $args);
        }
        return $methodCall;
    }
    private function createAutowire($value, \ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall $methodCall, string $type) : \ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall
    {
        if ($value === \true) {
            return new \ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall($methodCall, \ConfigTransformer202108114\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOWIRE);
        }
        // skip default false
        if ($type === self::TYPE_DEFAULTS) {
            return $methodCall;
        }
        $args = [new \ConfigTransformer202108114\PhpParser\Node\Arg($this->commonNodeFactory->createFalse())];
        return new \ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall($methodCall, \ConfigTransformer202108114\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOWIRE, $args);
    }
    private function createAutoconfigure($value, \ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall $methodCall, string $type) : \ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall
    {
        if ($value === \true) {
            return new \ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall($methodCall, \ConfigTransformer202108114\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOCONFIGURE);
        }
        // skip default false
        if ($type === self::TYPE_DEFAULTS) {
            return $methodCall;
        }
        $args = [new \ConfigTransformer202108114\PhpParser\Node\Arg($this->commonNodeFactory->createFalse())];
        return new \ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall($methodCall, \ConfigTransformer202108114\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOCONFIGURE, $args);
    }
    private function createPublicPrivate($value, \ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall $methodCall, string $type) : \ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall
    {
        if ($value !== \false) {
            return new \ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall($methodCall, 'public');
        }
        // default value
        if ($type === self::TYPE_DEFAULTS) {
            if ($this->symfonyVersionFeatureGuard->isAtLeastSymfonyVersion(\ConfigTransformer202108114\Symplify\PhpConfigPrinter\ValueObject\SymfonyVersionFeature::PRIVATE_SERVICES_BY_DEFAULT)) {
                return $methodCall;
            }
            return new \ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall($methodCall, 'private');
        }
        $args = [new \ConfigTransformer202108114\PhpParser\Node\Arg($this->commonNodeFactory->createFalse())];
        return new \ConfigTransformer202108114\PhpParser\Node\Expr\MethodCall($methodCall, 'public', $args);
    }
}
