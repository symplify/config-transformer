<?php

declare (strict_types=1);
namespace ConfigTransformer202108221\Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformer202108221\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202108221\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202108221\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202108221\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class DeprecatedServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202108221\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\ConfigTransformer202108221\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    public function decorateServiceMethodCall($key, $yaml, $values, $methodCall) : \ConfigTransformer202108221\PhpParser\Node\Expr\MethodCall
    {
        // the old, simple format
        if (!\is_array($yaml)) {
            $args = $this->argsNodeFactory->createFromValues([$yaml]);
        } else {
            $items = [$yaml['package'] ?? '', $yaml['version'] ?? '', $yaml['message'] ?? ''];
            $args = $this->argsNodeFactory->createFromValues($items);
        }
        return new \ConfigTransformer202108221\PhpParser\Node\Expr\MethodCall($methodCall, 'deprecate', $args);
    }
    public function isMatch($key, $values) : bool
    {
        return $key === \ConfigTransformer202108221\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::DEPRECATED;
    }
}
