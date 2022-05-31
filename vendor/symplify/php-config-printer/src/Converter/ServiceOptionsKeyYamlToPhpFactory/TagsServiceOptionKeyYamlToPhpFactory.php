<?php

declare (strict_types=1);
namespace ConfigTransformer202205319\Symplify\PhpConfigPrinter\Converter\ServiceOptionsKeyYamlToPhpFactory;

use ConfigTransformer202205319\Nette\Utils\Arrays;
use ConfigTransformer202205319\PhpParser\BuilderHelpers;
use ConfigTransformer202205319\PhpParser\Node\Arg;
use ConfigTransformer202205319\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202205319\PhpParser\Node\Scalar\String_;
use ConfigTransformer202205319\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use ConfigTransformer202205319\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202205319\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class TagsServiceOptionKeyYamlToPhpFactory implements \ConfigTransformer202205319\Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @var string
     */
    private const TAG = 'tag';
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    public function __construct(\ConfigTransformer202205319\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $yamlLines
     * @param mixed $values
     */
    public function decorateServiceMethodCall($key, $yamlLines, $values, \ConfigTransformer202205319\PhpParser\Node\Expr\MethodCall $methodCall) : \ConfigTransformer202205319\PhpParser\Node\Expr\MethodCall
    {
        if ($this->isSingleLineYamlLines($yamlLines)) {
            /** @var string[] $yamlLines */
            $string = new \ConfigTransformer202205319\PhpParser\Node\Scalar\String_($yamlLines[0]);
            return new \ConfigTransformer202205319\PhpParser\Node\Expr\MethodCall($methodCall, self::TAG, [new \ConfigTransformer202205319\PhpParser\Node\Arg($string)]);
        }
        foreach ($yamlLines as $yamlLine) {
            if (\is_string($yamlLine)) {
                $arg = new \ConfigTransformer202205319\PhpParser\Node\Arg(\ConfigTransformer202205319\PhpParser\BuilderHelpers::normalizeValue($yamlLine));
                $args = $this->argsNodeFactory->createFromValues($arg);
                $methodCall = new \ConfigTransformer202205319\PhpParser\Node\Expr\MethodCall($methodCall, self::TAG, $args);
                continue;
            }
            $args = [];
            $flattenedYmlLine = \ConfigTransformer202205319\Nette\Utils\Arrays::flatten($yamlLine, \true);
            foreach ($flattenedYmlLine as $singleNestedKey => $singleNestedValue) {
                if ($singleNestedKey === 'name') {
                    $args[] = new \ConfigTransformer202205319\PhpParser\Node\Arg(\ConfigTransformer202205319\PhpParser\BuilderHelpers::normalizeValue($singleNestedValue));
                    unset($flattenedYmlLine[$singleNestedKey]);
                }
            }
            $restArgs = $this->argsNodeFactory->createFromValuesAndWrapInArray($flattenedYmlLine);
            $args = \array_merge($args, $restArgs);
            $methodCall = new \ConfigTransformer202205319\PhpParser\Node\Expr\MethodCall($methodCall, self::TAG, $args);
        }
        return $methodCall;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return $key === \ConfigTransformer202205319\Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey::TAGS;
    }
    /**
     * @param mixed[] $yamlLines
     */
    private function isSingleLineYamlLines(array $yamlLines) : bool
    {
        return \count($yamlLines) === 1 && \is_string($yamlLines[0]);
    }
}
