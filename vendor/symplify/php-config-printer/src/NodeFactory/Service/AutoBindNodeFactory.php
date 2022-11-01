<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeFactory\Service;

use ConfigTransformer202211\PhpParser\Node\Expr\MethodCall;
use Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory\TagsServiceOptionKeyYamlToPhpFactory;
use Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class AutoBindNodeFactory
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory\TagsServiceOptionKeyYamlToPhpFactory
     */
    private $tagsServiceOptionKeyYamlToPhpFactory;
    public function __construct(ArgsNodeFactory $argsNodeFactory, TagsServiceOptionKeyYamlToPhpFactory $tagsServiceOptionKeyYamlToPhpFactory)
    {
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
     */
    public function createAutoBindCalls(array $yaml, MethodCall $methodCall) : MethodCall
    {
        foreach ($yaml as $key => $value) {
            if ($key === YamlKey::AUTOWIRE) {
                $methodCall = $this->createAutowire($value, $methodCall);
            }
            if ($key === YamlKey::AUTOCONFIGURE) {
                $methodCall = $this->createAutoconfigure($value, $methodCall);
            }
            if ($key === YamlKey::PUBLIC) {
                $methodCall = $this->createPublicPrivate($value, $methodCall);
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
    private function createAutowire($value, MethodCall $methodCall) : MethodCall
    {
        if ($value === \true) {
            return new MethodCall($methodCall, YamlKey::AUTOWIRE);
        }
        return $methodCall;
    }
    /**
     * @param mixed $value
     */
    private function createAutoconfigure($value, MethodCall $methodCall) : MethodCall
    {
        if ($value === \true) {
            return new MethodCall($methodCall, YamlKey::AUTOCONFIGURE);
        }
        return $methodCall;
    }
    /**
     * @param mixed $value
     */
    private function createPublicPrivate($value, MethodCall $methodCall) : MethodCall
    {
        if ($value !== \false) {
            return new MethodCall($methodCall, 'public');
        }
        // default value
        return $methodCall;
    }
}
