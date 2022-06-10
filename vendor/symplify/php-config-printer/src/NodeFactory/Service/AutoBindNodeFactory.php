<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeFactory\Service;

use ConfigTransformer20220610\PhpParser\Node\Arg;
use ConfigTransformer20220610\PhpParser\Node\Expr\MethodCall;
use Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory\TagsServiceOptionKeyYamlToPhpFactory;
use Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\YamlKey;
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
     * @var \Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory\TagsServiceOptionKeyYamlToPhpFactory
     */
    private $tagsServiceOptionKeyYamlToPhpFactory;
    public function __construct(CommonNodeFactory $commonNodeFactory, ArgsNodeFactory $argsNodeFactory, TagsServiceOptionKeyYamlToPhpFactory $tagsServiceOptionKeyYamlToPhpFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
        $this->tagsServiceOptionKeyYamlToPhpFactory = $tagsServiceOptionKeyYamlToPhpFactory;
    }
    /**
     * Decorated node with:
     * ->autowire()
     * ->autoconfigure()
     * ->bind()
     *
     * @param mixed[] $yaml
     * @param AutoBindNodeFactory::* $type
     */
    public function createAutoBindCalls(array $yaml, MethodCall $methodCall, string $type) : MethodCall
    {
        foreach ($yaml as $key => $value) {
            if ($key === YamlKey::AUTOWIRE) {
                $methodCall = $this->createAutowire($value, $methodCall, $type);
            }
            if ($key === YamlKey::AUTOCONFIGURE) {
                $methodCall = $this->createAutoconfigure($value, $methodCall, $type);
            }
            if ($key === YamlKey::PUBLIC) {
                $methodCall = $this->createPublicPrivate($value, $methodCall, $type);
            }
            if ($key === YamlKey::BIND) {
                $methodCall = $this->createBindMethodCall($methodCall, $yaml[YamlKey::BIND]);
            }
            if ($key === YamlKey::TAGS) {
                $methodCall = $this->tagsServiceOptionKeyYamlToPhpFactory->decorateServiceMethodCall(null, $value, [], $methodCall);
            }
        }
        return $methodCall;
    }
    /**
     * @param mixed[] $bindValues
     */
    private function createBindMethodCall(MethodCall $methodCall, array $bindValues) : MethodCall
    {
        foreach ($bindValues as $key => $value) {
            $args = $this->argsNodeFactory->createFromValues([$key, $value]);
            $methodCall = new MethodCall($methodCall, YamlKey::BIND, $args);
        }
        return $methodCall;
    }
    /**
     * @param mixed $value
     */
    private function createAutowire($value, MethodCall $methodCall, string $type) : MethodCall
    {
        if ($value === \true) {
            return new MethodCall($methodCall, YamlKey::AUTOWIRE);
        }
        // skip default false
        if ($type === self::TYPE_DEFAULTS) {
            return $methodCall;
        }
        $args = [new Arg($this->commonNodeFactory->createFalse())];
        return new MethodCall($methodCall, YamlKey::AUTOWIRE, $args);
    }
    /**
     * @param mixed $value
     */
    private function createAutoconfigure($value, MethodCall $methodCall, string $type) : MethodCall
    {
        if ($value === \true) {
            return new MethodCall($methodCall, YamlKey::AUTOCONFIGURE);
        }
        // skip default false
        if ($type === self::TYPE_DEFAULTS) {
            return $methodCall;
        }
        $args = [new Arg($this->commonNodeFactory->createFalse())];
        return new MethodCall($methodCall, YamlKey::AUTOCONFIGURE, $args);
    }
    /**
     * @param mixed $value
     */
    private function createPublicPrivate($value, MethodCall $methodCall, string $type) : MethodCall
    {
        if ($value !== \false) {
            return new MethodCall($methodCall, 'public');
        }
        // default value
        if ($type === self::TYPE_DEFAULTS) {
            return $methodCall;
        }
        $args = [new Arg($this->commonNodeFactory->createFalse())];
        return new MethodCall($methodCall, 'public', $args);
    }
}
