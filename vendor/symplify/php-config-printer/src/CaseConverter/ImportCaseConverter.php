<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformerPrefix202501\Nette\Utils\Strings;
use ConfigTransformerPrefix202501\PhpParser\BuilderHelpers;
use ConfigTransformerPrefix202501\PhpParser\Node\Arg;
use ConfigTransformerPrefix202501\PhpParser\Node\Expr;
use ConfigTransformerPrefix202501\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformerPrefix202501\PhpParser\Node\Expr\MethodCall;
use ConfigTransformerPrefix202501\PhpParser\Node\Expr\Variable;
use ConfigTransformerPrefix202501\PhpParser\Node\Name\FullyQualified;
use ConfigTransformerPrefix202501\PhpParser\Node\Scalar\String_;
use ConfigTransformerPrefix202501\PhpParser\Node\Stmt;
use ConfigTransformerPrefix202501\PhpParser\Node\Stmt\Expression;
use Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use Symplify\PhpConfigPrinter\Exception\NotImplementedYetException;
use Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use Symplify\PhpConfigPrinter\Sorter\YamlArgumentSorter;
use Symplify\PhpConfigPrinter\ValueObject\VariableName;
use Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * imports: <---
 */
final class ImportCaseConverter implements CaseConverterInterface
{
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\Sorter\YamlArgumentSorter
     */
    private $yamlArgumentSorter;
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    /**
     * @see https://regex101.com/r/hOTdIE/1
     * @var string
     */
    private const INPUT_SUFFIX_REGEX = '#\\.(yml|yaml|xml)$#';
    public function __construct(YamlArgumentSorter $yamlArgumentSorter, CommonNodeFactory $commonNodeFactory)
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
        return $rootKey === YamlKey::IMPORTS;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCallStmt($key, $values) : Stmt
    {
        if (\is_array($values)) {
            $arguments = $this->yamlArgumentSorter->sortArgumentsByKeyIfExists($values, [YamlKey::RESOURCE => '', 'type' => null, YamlKey::IGNORE_ERRORS => \false]);
            return $this->createImportMethodCall($arguments);
        }
        if (\is_string($values)) {
            return $this->createImportMethodCall([$values]);
        }
        throw new NotImplementedYetException();
    }
    /**
     * @param mixed[] $arguments
     */
    private function createImportMethodCall(array $arguments) : Expression
    {
        $containerConfiguratorVariable = new Variable(VariableName::CONTAINER_CONFIGURATOR);
        $args = $this->createArgs($arguments);
        $methodCall = new MethodCall($containerConfiguratorVariable, 'import', $args);
        return new Expression($methodCall);
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
            $args[] = new Arg($expr);
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
        if ($name === YamlKey::IGNORE_ERRORS && $value === \false) {
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
        if (!isset($arguments[YamlKey::IGNORE_ERRORS])) {
            return \false;
        }
        return $arguments[YamlKey::IGNORE_ERRORS] === \false;
    }
    /**
     * @param mixed $value
     * @return mixed
     */
    private function replaceImportedFileSuffix($value)
    {
        if (!\is_string($value)) {
            return $value;
        }
        return Strings::replace($value, self::INPUT_SUFFIX_REGEX, '.php');
    }
    /**
     * @param mixed $value
     */
    private function resolveExpr($value) : Expr
    {
        $expr = $this->processNormalizedValue($value);
        if ($expr instanceof Expr) {
            return $expr;
        }
        if ($value === 'not_found') {
            return new String_('not_found');
        }
        if (\is_string($value) && \strpos($value, '::') !== \false) {
            [$className, $constantName] = \explode('::', $value);
            return new ClassConstFetch(new FullyQualified($className), $constantName);
        }
        if (\is_string($value) && \strncmp($value, '@', \strlen('@')) === 0) {
            return new String_($value);
        }
        $value = $this->replaceImportedFileSuffix($value);
        if (\is_string($value) && \strncmp($value, '%', \strlen('%')) === 0) {
            return new String_($value);
        }
        return $this->commonNodeFactory->createAbsoluteDirExpr($value);
    }
    /**
     * @param mixed $value
     */
    private function processNormalizedValue($value) : ?Expr
    {
        if (\is_bool($value)) {
            return BuilderHelpers::normalizeValue($value);
        }
        if (\in_array($value, ['annotations', 'directory', 'glob'], \true)) {
            return BuilderHelpers::normalizeValue($value);
        }
        return null;
    }
}
