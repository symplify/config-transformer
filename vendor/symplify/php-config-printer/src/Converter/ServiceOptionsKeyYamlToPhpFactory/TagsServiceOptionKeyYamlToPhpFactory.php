<?php

declare (strict_types=1);
namespace ConfigTransformer2021081610\Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory;

use ConfigTransformer2021081610\PhpParser\BuilderHelpers;
use ConfigTransformer2021081610\PhpParser\Node\Arg;
use ConfigTransformer2021081610\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021081610\PhpParser\Node\Scalar\String_;
use ConfigTransformer2021081610\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer2021081610\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer2021081610\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class TagsServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer2021081610\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var string
     */
    private const TAG = 'tag';
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\ConfigTransformer2021081610\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    public function decorateServiceMethodCall($key, $yaml, $values, $methodCall) : \ConfigTransformer2021081610\PhpParser\Node\Expr\MethodCall
    {
        /** @var mixed[] $yaml */
        if (\count($yaml) === 1 && \is_string($yaml[0])) {
            $string = new \ConfigTransformer2021081610\PhpParser\Node\Scalar\String_($yaml[0]);
            return new \ConfigTransformer2021081610\PhpParser\Node\Expr\MethodCall($methodCall, self::TAG, [new \ConfigTransformer2021081610\PhpParser\Node\Arg($string)]);
        }
        foreach ($yaml as $singleValue) {
            $args = [];
            foreach ($singleValue as $singleNestedKey => $singleNestedValue) {
                if ($singleNestedKey === 'name') {
                    $args[] = new \ConfigTransformer2021081610\PhpParser\Node\Arg(\ConfigTransformer2021081610\PhpParser\BuilderHelpers::normalizeValue($singleNestedValue));
                    unset($singleValue[$singleNestedKey]);
                }
            }
            $restArgs = $this->argsNodeFactory->createFromValuesAndWrapInArray($singleValue);
            $args = \array_merge($args, $restArgs);
            $methodCall = new \ConfigTransformer2021081610\PhpParser\Node\Expr\MethodCall($methodCall, self::TAG, $args);
        }
        return $methodCall;
    }
    public function isMatch($key, $values) : bool
    {
        return $key === \ConfigTransformer2021081610\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::TAGS;
    }
}
