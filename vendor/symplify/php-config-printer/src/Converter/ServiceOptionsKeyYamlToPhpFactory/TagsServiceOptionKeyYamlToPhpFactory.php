<?php

declare (strict_types=1);
namespace ConfigTransformer202111011\Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory;

use ConfigTransformer202111011\PhpParser\BuilderHelpers;
use ConfigTransformer202111011\PhpParser\Node\Arg;
use ConfigTransformer202111011\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202111011\PhpParser\Node\Scalar\String_;
use ConfigTransformer202111011\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202111011\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202111011\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class TagsServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202111011\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var string
     */
    private const TAG = 'tag';
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\ConfigTransformer202111011\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    public function decorateServiceMethodCall($key, $yamlLines, $values, $methodCall) : \ConfigTransformer202111011\PhpParser\Node\Expr\MethodCall
    {
        /** @var mixed[] $yamlLines */
        if (\count($yamlLines) === 1 && \is_string($yamlLines[0])) {
            $string = new \ConfigTransformer202111011\PhpParser\Node\Scalar\String_($yamlLines[0]);
            return new \ConfigTransformer202111011\PhpParser\Node\Expr\MethodCall($methodCall, self::TAG, [new \ConfigTransformer202111011\PhpParser\Node\Arg($string)]);
        }
        foreach ($yamlLines as $yamlLine) {
            $args = [];
            foreach ($yamlLine as $singleNestedKey => $singleNestedValue) {
                if ($singleNestedKey === 'name') {
                    $args[] = new \ConfigTransformer202111011\PhpParser\Node\Arg(\ConfigTransformer202111011\PhpParser\BuilderHelpers::normalizeValue($singleNestedValue));
                    unset($yamlLine[$singleNestedKey]);
                }
            }
            $restArgs = $this->argsNodeFactory->createFromValuesAndWrapInArray($yamlLine);
            $args = \array_merge($args, $restArgs);
            $methodCall = new \ConfigTransformer202111011\PhpParser\Node\Expr\MethodCall($methodCall, self::TAG, $args);
        }
        return $methodCall;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return $key === \ConfigTransformer202111011\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::TAGS;
    }
}
