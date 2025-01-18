<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\ServiceOptionConverter;

use ConfigTransformerPrefix202501\Nette\Utils\Arrays;
use ConfigTransformerPrefix202501\PhpParser\BuilderHelpers;
use ConfigTransformerPrefix202501\PhpParser\Node\Arg;
use ConfigTransformerPrefix202501\PhpParser\Node\Expr\Array_;
use ConfigTransformerPrefix202501\PhpParser\Node\Expr\MethodCall;
use ConfigTransformerPrefix202501\PhpParser\Node\Scalar\String_;
use Symplify\PhpConfigPrinter\Contract\Converter\ServiceOptionsKeyYamlToPhpFactoryInterface;
use Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use Symplify\PhpConfigPrinter\ValueObject\YamlServiceKey;
final class TagsServiceOptionKeyYamlToPhpFactory implements ServiceOptionsKeyYamlToPhpFactoryInterface
{
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var string
     */
    private const TAG = 'tag';
    public function __construct(ArgsNodeFactory $argsNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $yamlLines
     * @param mixed $values
     */
    public function decorateServiceMethodCall($key, $yamlLines, $values, MethodCall $methodCall) : MethodCall
    {
        if ($this->isSingleLineYamlLines($yamlLines)) {
            /** @var string[] $yamlLines */
            $string = new String_($yamlLines[0]);
            return new MethodCall($methodCall, self::TAG, [new Arg($string)]);
        }
        foreach ($yamlLines as $yamlLine) {
            if (\is_string($yamlLine)) {
                $arg = new Arg(BuilderHelpers::normalizeValue($yamlLine));
                $args = $this->argsNodeFactory->createFromValues($arg);
                $methodCall = new MethodCall($methodCall, self::TAG, $args);
                continue;
            }
            $args = [];
            $flattenedYmlLine = Arrays::flatten($yamlLine, \true);
            foreach ($flattenedYmlLine as $singleNestedKey => $singleNestedValue) {
                if ($singleNestedKey === 'name') {
                    $args[] = new Arg(BuilderHelpers::normalizeValue($singleNestedValue));
                    unset($flattenedYmlLine[$singleNestedKey]);
                }
            }
            $restArgs = $this->argsNodeFactory->createFromValuesAndWrapInArray($flattenedYmlLine);
            $args = \array_merge($args, $restArgs);
            $args = $this->removeEmptySecondArgArray($args);
            $methodCall = new MethodCall($methodCall, self::TAG, $args);
        }
        return $methodCall;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function isMatch($key, $values) : bool
    {
        return $key === YamlServiceKey::TAGS;
    }
    /**
     * @param mixed[] $yamlLines
     */
    private function isSingleLineYamlLines(array $yamlLines) : bool
    {
        return \count($yamlLines) === 1 && \is_string($yamlLines[0]);
    }
    /**
     * @param Arg[] $args
     * @return Arg[]
     */
    private function removeEmptySecondArgArray(array $args) : array
    {
        if (!isset($args[1])) {
            return $args;
        }
        $secondArgValue = $args[1]->value;
        if (!$secondArgValue instanceof Array_) {
            return $args;
        }
        if ($secondArgValue->items !== []) {
            return $args;
        }
        unset($args[1]);
        return $args;
    }
}
