<?php

declare (strict_types=1);
namespace ConfigTransformer202205134\Symplify\PhpConfigPrinter\NodeFactory\Service;

use ConfigTransformer202205134\PhpParser\Node\Arg;
use ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202205134\Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory\TagsServiceOptionKeyYamlToPhpFactory;
use ConfigTransformer202205134\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202205134\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer202205134\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
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
    public function __construct(\ConfigTransformer202205134\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \ConfigTransformer202205134\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer202205134\Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory\TagsServiceOptionKeyYamlToPhpFactory $tagsServiceOptionKeyYamlToPhpFactory)
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
     */
    public function createAutoBindCalls(array $yaml, \ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall $methodCall, string $type) : \ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall
    {
        foreach ($yaml as $key => $value) {
            if ($key === \ConfigTransformer202205134\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOWIRE) {
                $methodCall = $this->createAutowire($value, $methodCall, $type);
            }
            if ($key === \ConfigTransformer202205134\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOCONFIGURE) {
                $methodCall = $this->createAutoconfigure($value, $methodCall, $type);
            }
            if ($key === \ConfigTransformer202205134\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PUBLIC) {
                $methodCall = $this->createPublicPrivate($value, $methodCall, $type);
            }
            if ($key === \ConfigTransformer202205134\Symplify\PhpConfigPrinter\ValueObject\YamlKey::BIND) {
                $methodCall = $this->createBindMethodCall($methodCall, $yaml[\ConfigTransformer202205134\Symplify\PhpConfigPrinter\ValueObject\YamlKey::BIND]);
            }
            if ($key === \ConfigTransformer202205134\Symplify\PhpConfigPrinter\ValueObject\YamlKey::TAGS) {
                $methodCall = $this->tagsServiceOptionKeyYamlToPhpFactory->decorateServiceMethodCall(null, $value, [], $methodCall);
            }
        }
        return $methodCall;
    }
    /**
     * @param mixed[] $bindValues
     */
    private function createBindMethodCall(\ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall $methodCall, array $bindValues) : \ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall
    {
        foreach ($bindValues as $key => $value) {
            $args = $this->argsNodeFactory->createFromValues([$key, $value]);
            $methodCall = new \ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall($methodCall, \ConfigTransformer202205134\Symplify\PhpConfigPrinter\ValueObject\YamlKey::BIND, $args);
        }
        return $methodCall;
    }
    /**
     * @param mixed $value
     */
    private function createAutowire($value, \ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall $methodCall, string $type) : \ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall
    {
        if ($value === \true) {
            return new \ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall($methodCall, \ConfigTransformer202205134\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOWIRE);
        }
        // skip default false
        if ($type === self::TYPE_DEFAULTS) {
            return $methodCall;
        }
        $args = [new \ConfigTransformer202205134\PhpParser\Node\Arg($this->commonNodeFactory->createFalse())];
        return new \ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall($methodCall, \ConfigTransformer202205134\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOWIRE, $args);
    }
    /**
     * @param mixed $value
     */
    private function createAutoconfigure($value, \ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall $methodCall, string $type) : \ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall
    {
        if ($value === \true) {
            return new \ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall($methodCall, \ConfigTransformer202205134\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOCONFIGURE);
        }
        // skip default false
        if ($type === self::TYPE_DEFAULTS) {
            return $methodCall;
        }
        $args = [new \ConfigTransformer202205134\PhpParser\Node\Arg($this->commonNodeFactory->createFalse())];
        return new \ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall($methodCall, \ConfigTransformer202205134\Symplify\PhpConfigPrinter\ValueObject\YamlKey::AUTOCONFIGURE, $args);
    }
    /**
     * @param mixed $value
     */
    private function createPublicPrivate($value, \ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall $methodCall, string $type) : \ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall
    {
        if ($value !== \false) {
            return new \ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall($methodCall, 'public');
        }
        // default value
        if ($type === self::TYPE_DEFAULTS) {
            return $methodCall;
        }
        $args = [new \ConfigTransformer202205134\PhpParser\Node\Arg($this->commonNodeFactory->createFalse())];
        return new \ConfigTransformer202205134\PhpParser\Node\Expr\MethodCall($methodCall, 'public', $args);
    }
}
