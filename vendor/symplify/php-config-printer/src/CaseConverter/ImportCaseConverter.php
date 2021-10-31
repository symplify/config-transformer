<?php

declare (strict_types=1);
namespace ConfigTransformer202110311\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202110311\Nette\Utils\Strings;
use ConfigTransformer202110311\PhpParser\BuilderHelpers;
use ConfigTransformer202110311\PhpParser\Node\Arg;
use ConfigTransformer202110311\PhpParser\Node\Expr;
use ConfigTransformer202110311\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer202110311\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202110311\PhpParser\Node\Expr\Variable;
use ConfigTransformer202110311\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer202110311\PhpParser\Node\Scalar\String_;
use ConfigTransformer202110311\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202110311\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202110311\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException;
use ConfigTransformer202110311\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer202110311\Symplify\PhpConfigPrinter\Sorter\YamlArgumentSorter;
use ConfigTransformer202110311\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202110311\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * imports: <---
 */
final class ImportCaseConverter implements \ConfigTransformer202110311\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
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
    public function __construct(\ConfigTransformer202110311\Symplify\PhpConfigPrinter\Sorter\YamlArgumentSorter $yamlArgumentSorter, \ConfigTransformer202110311\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory)
    {
        $this->yamlArgumentSorter = $yamlArgumentSorter;
        $this->commonNodeFactory = $commonNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool
    {
        return $rootKey === \ConfigTransformer202110311\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IMPORTS;
    }
    /**
     * @param mixed $values
     * @param mixed $key
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer202110311\PhpParser\Node\Stmt\Expression
    {
        if (\is_array($values)) {
            $arguments = $this->yamlArgumentSorter->sortArgumentsByKeyIfExists($values, [\ConfigTransformer202110311\Symplify\PhpConfigPrinter\ValueObject\YamlKey::RESOURCE => '', 'type' => null, \ConfigTransformer202110311\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS => \false]);
            return $this->createImportMethodCall($arguments);
        }
        if (\is_string($values)) {
            return $this->createImportMethodCall([$values]);
        }
        throw new \ConfigTransformer202110311\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException();
    }
    /**
     * @param mixed[] $arguments
     */
    private function createImportMethodCall(array $arguments) : \ConfigTransformer202110311\PhpParser\Node\Stmt\Expression
    {
        $containerConfiguratorVariable = new \ConfigTransformer202110311\PhpParser\Node\Expr\Variable(\ConfigTransformer202110311\Symplify\PhpConfigPrinter\ValueObject\VariableName::CONTAINER_CONFIGURATOR);
        $args = $this->createArgs($arguments);
        $methodCall = new \ConfigTransformer202110311\PhpParser\Node\Expr\MethodCall($containerConfiguratorVariable, 'import', $args);
        return new \ConfigTransformer202110311\PhpParser\Node\Stmt\Expression($methodCall);
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
            $args[] = new \ConfigTransformer202110311\PhpParser\Node\Arg($expr);
        }
        return $args;
    }
    /**
     * @param mixed $value
     */
    private function shouldSkipDefaultValue(string $name, $value, array $arguments) : bool
    {
        // skip default value for "ignore_errors"
        if ($name === \ConfigTransformer202110311\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS && $value === \false) {
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
        if (!isset($arguments[\ConfigTransformer202110311\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS])) {
            return \false;
        }
        return $arguments[\ConfigTransformer202110311\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS] === \false;
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
        return \ConfigTransformer202110311\Nette\Utils\Strings::replace($value, self::INPUT_SUFFIX_REGEX, '.php');
    }
    /**
     * @param mixed $value
     */
    private function resolveExpr($value) : \ConfigTransformer202110311\PhpParser\Node\Expr
    {
        if (\is_bool($value)) {
            return \ConfigTransformer202110311\PhpParser\BuilderHelpers::normalizeValue($value);
        }
        if (\in_array($value, ['annotations', 'directory', 'glob'], \true)) {
            return \ConfigTransformer202110311\PhpParser\BuilderHelpers::normalizeValue($value);
        }
        if ($value === 'not_found') {
            return new \ConfigTransformer202110311\PhpParser\Node\Scalar\String_('not_found');
        }
        if (\is_string($value) && \strpos($value, '::') !== \false) {
            [$className, $constantName] = \explode('::', $value);
            return new \ConfigTransformer202110311\PhpParser\Node\Expr\ClassConstFetch(new \ConfigTransformer202110311\PhpParser\Node\Name\FullyQualified($className), $constantName);
        }
        $value = $this->replaceImportedFileSuffix($value);
        return $this->commonNodeFactory->createAbsoluteDirExpr($value);
    }
}
