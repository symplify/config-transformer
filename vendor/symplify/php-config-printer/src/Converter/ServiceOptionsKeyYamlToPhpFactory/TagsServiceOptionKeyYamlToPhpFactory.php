<?php

declare (strict_types=1);
namespace ConfigTransformer2021070510\Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory;

use ConfigTransformer2021070510\PhpParser\BuilderHelpers;
use ConfigTransformer2021070510\PhpParser\Node\Arg;
use ConfigTransformer2021070510\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021070510\PhpParser\Node\Scalar\String_;
use ConfigTransformer2021070510\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer2021070510\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer2021070510\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class TagsServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer2021070510\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var string
     */
    private const TAG = 'tag';
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\ConfigTransformer2021070510\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    public function decorateServiceMethodCall($key, $yaml, $values, \ConfigTransformer2021070510\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer2021070510\PhpParser\Node\Expr\MethodCall
    {
        /** @var mixed[] $yaml */
        if (\count($yaml) === 1 && \is_string($yaml[0])) {
            $string = new \ConfigTransformer2021070510\PhpParser\Node\Scalar\String_($yaml[0]);
            return new \ConfigTransformer2021070510\PhpParser\Node\Expr\MethodCall($methodCall, self::TAG, [new \ConfigTransformer2021070510\PhpParser\Node\Arg($string)]);
        }
        foreach ($yaml as $singleValue) {
            $args = [];
            foreach ($singleValue as $singleNestedKey => $singleNestedValue) {
                if ($singleNestedKey === 'name') {
                    $args[] = new \ConfigTransformer2021070510\PhpParser\Node\Arg(\ConfigTransformer2021070510\PhpParser\BuilderHelpers::normalizeValue($singleNestedValue));
                    unset($singleValue[$singleNestedKey]);
                }
            }
            $restArgs = $this->argsNodeFactory->createFromValuesAndWrapInArray($singleValue);
            $args = \array_merge($args, $restArgs);
            $methodCall = new \ConfigTransformer2021070510\PhpParser\Node\Expr\MethodCall($methodCall, self::TAG, $args);
        }
        return $methodCall;
    }
    public function isMatch($key, $values) : bool
    {
        return $key === \ConfigTransformer2021070510\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::TAGS;
    }
}
