<?php

declare (strict_types=1);
namespace ConfigTransformer2021112210\Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory;

use ConfigTransformer2021112210\PhpParser\BuilderHelpers;
use ConfigTransformer2021112210\PhpParser\Node\Arg;
use ConfigTransformer2021112210\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2021112210\PhpParser\Node\Scalar\String_;
use ConfigTransformer2021112210\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer2021112210\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer2021112210\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class TagsServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer2021112210\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var string
     */
    private const TAG = 'tag';
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\ConfigTransformer2021112210\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    /**
     * @param \PhpParser\Node\Expr\MethodCall $methodCall
     */
    public function decorateServiceMethodCall($key, $yamlLines, $values, $methodCall) : \ConfigTransformer2021112210\PhpParser\Node\Expr\MethodCall
    {
        if ($this->isSingleLineYamlLines($yamlLines)) {
            /** @var string[] $yamlLines */
            $string = new \ConfigTransformer2021112210\PhpParser\Node\Scalar\String_($yamlLines[0]);
            return new \ConfigTransformer2021112210\PhpParser\Node\Expr\MethodCall($methodCall, self::TAG, [new \ConfigTransformer2021112210\PhpParser\Node\Arg($string)]);
        }
        foreach ($yamlLines as $yamlLine) {
            if (\is_string($yamlLine)) {
                $arg = new \ConfigTransformer2021112210\PhpParser\Node\Arg(\ConfigTransformer2021112210\PhpParser\BuilderHelpers::normalizeValue($yamlLine));
                $args = $this->argsNodeFactory->createFromValues($arg);
                $methodCall = new \ConfigTransformer2021112210\PhpParser\Node\Expr\MethodCall($methodCall, self::TAG, $args);
                continue;
            }
            $args = [];
            foreach ($yamlLine as $singleNestedKey => $singleNestedValue) {
                if ($singleNestedKey === 'name') {
                    $args[] = new \ConfigTransformer2021112210\PhpParser\Node\Arg(\ConfigTransformer2021112210\PhpParser\BuilderHelpers::normalizeValue($singleNestedValue));
                    unset($yamlLine[$singleNestedKey]);
                }
            }
            $restArgs = $this->argsNodeFactory->createFromValuesAndWrapInArray($yamlLine);
            $args = \array_merge($args, $restArgs);
            $methodCall = new \ConfigTransformer2021112210\PhpParser\Node\Expr\MethodCall($methodCall, self::TAG, $args);
        }
        return $methodCall;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return $key === \ConfigTransformer2021112210\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::TAGS;
    }
    /**
     * @param mixed[] $yamlLines
     */
    private function isSingleLineYamlLines(array $yamlLines) : bool
    {
        return \count($yamlLines) === 1 && \is_string($yamlLines[0]);
    }
}
