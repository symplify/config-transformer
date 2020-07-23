<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\KeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\CaseConverterInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\CommonNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\Provider\CurrentFilePathProvider;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\MethodName;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;

/**
 * Handles this part:
 *
 * parameters: <---
 */
final class ParameterKeyYamlToPhpFactory implements CaseConverterInterface
{
    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    /**
     * @var CurrentFilePathProvider
     */
    private $currentFilePathProvider;

    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    public function __construct(
        ArgsNodeFactory $argsNodeFactory,
        CurrentFilePathProvider $currentFilePathProvider,
        CommonNodeFactory $commonNodeFactory
    ) {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->currentFilePathProvider = $currentFilePathProvider;
        $this->commonNodeFactory = $commonNodeFactory;
    }

    public function getKey(): string
    {
        return YamlKey::PARAMETERS;
    }

    public function match(string $rootKey, $key, $values): bool
    {
        return $rootKey === YamlKey::PARAMETERS;
    }

    public function convertToMethodCall(string $key, $values): Expression
    {
        if (is_string($values)) {
            $values = $this->prefixWithDirConstantIfExistingPath($values);
        }

        if (is_array($values)) {
            foreach ($values as $subKey => $subValue) {
                if (! is_string($subValue)) {
                    continue;
                }
                $values[$subKey] = $this->prefixWithDirConstantIfExistingPath($subValue);
            }
        }

        $args = $this->argsNodeFactory->createFromValues([$key, $values]);

        $parametersVariable = new Variable(VariableName::PARAMETERS);
        $methodCall = new MethodCall($parametersVariable, MethodName::SET, $args);

        return new Expression($methodCall);
    }

    /**
     * @return Expr|string
     */
    private function prefixWithDirConstantIfExistingPath(string $value)
    {
        $configDirectory = dirname($this->currentFilePathProvider->getFilePath());

        $possibleConfigPath = $configDirectory . '/' . $value;
        if (is_file($possibleConfigPath) || is_dir($possibleConfigPath)) {
            return $this->commonNodeFactory->createAbsoluteDirExpr($value);
        }

        return $value;
    }
}
