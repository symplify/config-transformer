<?php

declare (strict_types=1);
namespace ConfigTransformer202110315\Symplify\PhpConfigPrinter\CaseConverter;

use ConfigTransformer202110315\PhpParser\Node\Expr;
use ConfigTransformer202110315\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202110315\PhpParser\Node\Expr\Variable;
use ConfigTransformer202110315\PhpParser\Node\Stmt\Expression;
use ConfigTransformer202110315\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use ConfigTransformer202110315\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory;
use ConfigTransformer202110315\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer202110315\Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider;
use ConfigTransformer202110315\Symplify\PhpConfigPrinter\ValueObject\MethodName;
use ConfigTransformer202110315\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use ConfigTransformer202110315\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * parameters: <---
 */
final class ParameterCaseConverter implements \ConfigTransformer202110315\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory
     */
    private $argsNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider
     */
    private $currentFilePathProvider;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    public function __construct(\ConfigTransformer202110315\Symplify\PhpConfigPrinter\NodeFactory\ArgsNodeFactory $argsNodeFactory, \ConfigTransformer202110315\Symplify\PhpConfigPrinter\Provider\CurrentFilePathProvider $currentFilePathProvider, \ConfigTransformer202110315\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->currentFilePathProvider = $currentFilePathProvider;
        $this->commonNodeFactory = $commonNodeFactory;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     * @param string $rootKey
     */
    public function match($rootKey, $key, $values) : bool
    {
        return $rootKey === \ConfigTransformer202110315\Symplify\PhpConfigPrinter\ValueObject\YamlKey::PARAMETERS;
    }
    /**
     * @param mixed $key
     * @param mixed $values
     */
    public function convertToMethodCall($key, $values) : \ConfigTransformer202110315\PhpParser\Node\Stmt\Expression
    {
        if (\is_string($values)) {
            $values = $this->prefixWithDirConstantIfExistingPath($values);
        }
        if (\is_array($values)) {
            foreach ($values as $subKey => $subValue) {
                if (!\is_string($subValue)) {
                    continue;
                }
                $values[$subKey] = $this->prefixWithDirConstantIfExistingPath($subValue);
            }
        }
        $args = $this->argsNodeFactory->createFromValues([$key, $values]);
        $parametersVariable = new \ConfigTransformer202110315\PhpParser\Node\Expr\Variable(\ConfigTransformer202110315\Symplify\PhpConfigPrinter\ValueObject\VariableName::PARAMETERS);
        $methodCall = new \ConfigTransformer202110315\PhpParser\Node\Expr\MethodCall($parametersVariable, \ConfigTransformer202110315\Symplify\PhpConfigPrinter\ValueObject\MethodName::SET, $args);
        return new \ConfigTransformer202110315\PhpParser\Node\Stmt\Expression($methodCall);
    }
    /**
     * @return \PhpParser\Node\Expr|string
     */
    private function prefixWithDirConstantIfExistingPath(string $value)
    {
        $filePath = $this->currentFilePathProvider->getFilePath();
        if ($filePath === null) {
            return $value;
        }
        $configDirectory = \dirname($filePath);
        $possibleConfigPath = $configDirectory . '/' . $value;
        if (\is_file($possibleConfigPath)) {
            return $this->commonNodeFactory->createAbsoluteDirExpr($value);
        }
        if (\is_dir($possibleConfigPath)) {
            return $this->commonNodeFactory->createAbsoluteDirExpr($value);
        }
        return $value;
    }
}
