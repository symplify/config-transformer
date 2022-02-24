<?php

declare (strict_types=1);
namespace ConfigTransformer2022022410\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer2022022410\Nette\Utils\Strings;
use ConfigTransformer2022022410\PhpParser\BuilderHelpers;
use ConfigTransformer2022022410\PhpParser\Node\Arg;
use ConfigTransformer2022022410\PhpParser\Node\Expr;
use ConfigTransformer2022022410\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer2022022410\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer2022022410\PhpParser\Node\Expr\Variable;
use ConfigTransformer2022022410\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer2022022410\PhpParser\Node\Scalar\String_;
use ConfigTransformer2022022410\PhpParser\Node\Stmt\Expression;
use ConfigTransformer2022022410\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer2022022410\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException;
use ConfigTransformer2022022410\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer2022022410\Symplify\PhpConfigPrinter\Sorter\YamlArgumentSorter;
use ConfigTransformer2022022410\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer2022022410\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * imports: <---
 */
final class ImportCaseConverter implements \ConfigTransformer2022022410\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @see https://regex101.com/r/hOTdIE/1
     * @var string
     */
    private const INPUT_SUFFIX_REGEX = '#\\.(yml|yaml|xml)$#';
    /**
     * @var \Symplify\PhpConfigPrinter\Sorter\YamlArgumentSorter
     */
    private $yamlArgumentSorter;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    public function __construct(\ConfigTransformer2022022410\Symplify\PhpConfigPrinter\Sorter\YamlArgumentSorter $yamlArgumentSorter, \ConfigTransformer2022022410\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory)
    {
        $this->yamlArgumentSorter = $yamlArgumentSorter;
        $this->commonNodeFactory = $commonNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function match(string $rootKey, $key, $values) : bool
    {
        return $rootKey === \ConfigTransformer2022022410\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IMPORTS;
    }
    /**
     * @param mixed $values
     * @param mixed $key
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer2022022410\PhpParser\Node\Stmt\Expression
    {
        if (\is_array($values)) {
            $arguments = $this->yamlArgumentSorter->sortArgumentsByKeyIfExists($values, [\ConfigTransformer2022022410\Symplify\PhpConfigPrinter\ValueObject\YamlKey::RESOURCE => '', 'type' => null, \ConfigTransformer2022022410\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS => \false]);
            return $this->createImportMethodCall($arguments);
        }
        if (\is_string($values)) {
            return $this->createImportMethodCall([$values]);
        }
        throw new \ConfigTransformer2022022410\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException();
    }
    /**
     * @param mixed[] $arguments
     */
    private function createImportMethodCall(array $arguments) : \ConfigTransformer2022022410\PhpParser\Node\Stmt\Expression
    {
        $containerConfiguratorVariable = new \ConfigTransformer2022022410\PhpParser\Node\Expr\Variable(\ConfigTransformer2022022410\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        $args = $this->createArgs($arguments);
        $methodCall = new \ConfigTransformer2022022410\PhpParser\Node\Expr\MethodCall($containerConfiguratorVariable, 'import', $args);
        return new \ConfigTransformer2022022410\PhpParser\Node\Stmt\Expression($methodCall);
    }
    /**
     * @param array<int|string, mixed> $arguments
     * @return Arg[]
     */
    private function createArgs(array $arguments) : array
    {
        $args = [];
        foreach ($arguments as $name => $value) {
            if (\is_string($name) && $this->shouldSkipDefaultValue($name, $value, $arguments)) {
                continue;
            }
            $expr = $this->resolveExpr($value);
            $args[] = new \ConfigTransformer2022022410\PhpParser\Node\Arg($expr);
        }
        return $args;
    }
    /**
     * @param mixed[] $arguments
     * @param mixed $value
     */
    private function shouldSkipDefaultValue(string $name, $value, array $arguments) : bool
    {
        // skip default value for "ignore_errors"
        if ($name === \ConfigTransformer2022022410\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS && $value === \false) {
            return \true;
        }
        // check if default value for "type"
        if ($name !== 'type') {
            return \false;
        }
        if ($value !== null) {
            return \false;
        }
        // follow by default value for "ignore_errors"
        if (!isset($arguments[\ConfigTransformer2022022410\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS])) {
            return \false;
        }
        return $arguments[\ConfigTransformer2022022410\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS] === \false;
    }
    /**
     * @return mixed|string
     * @param mixed $value
     */
    private function replaceImportedFileSuffix($value)
    {
        if (!\is_string($value)) {
            return $value;
        }
        return \ConfigTransformer2022022410\Nette\Utils\Strings::replace($value, self::INPUT_SUFFIX_REGEX, '.php');
    }
    /**
     * @param mixed $value
     */
    private function resolveExpr($value) : \ConfigTransformer2022022410\PhpParser\Node\Expr
    {
        if (\is_bool($value)) {
            return \ConfigTransformer2022022410\PhpParser\BuilderHelpers::normalizeValue($value);
        }
        if (\in_array($value, ['annotations', 'directory', 'glob'], \true)) {
            return \ConfigTransformer2022022410\PhpParser\BuilderHelpers::normalizeValue($value);
        }
        if ($value === 'not_found') {
            return new \ConfigTransformer2022022410\PhpParser\Node\Scalar\String_('not_found');
        }
        if (\is_string($value) && \strpos($value, '::') !== \false) {
            [$className, $constantName] = \explode('::', $value);
            return new \ConfigTransformer2022022410\PhpParser\Node\Expr\ClassConstFetch(new \ConfigTransformer2022022410\PhpParser\Node\Name\FullyQualified($className), $constantName);
        }
        $value = $this->replaceImportedFileSuffix($value);
        return $this->commonNodeFactory->createAbsoluteDirExpr($value);
    }
}
