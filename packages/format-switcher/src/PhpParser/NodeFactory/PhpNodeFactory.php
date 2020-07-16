<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Provider\CurrentFilePathProvider;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;

final class PhpNodeFactory
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
        CommonNodeFactory $commonNodeFactory,
        CurrentFilePathProvider $currentFilePathProvider
    ) {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->currentFilePathProvider = $currentFilePathProvider;
        $this->commonNodeFactory = $commonNodeFactory;
    }

    public function createParameterSetMethodCall(string $parameterName, $value): Expression
    {
        if (is_string($value)) {
            $value = $this->prefixWithDirConstantIfExistingPath($value);
        }

        if (is_array($value)) {
            foreach ($value as $subKey => $subValue) {
                if (! is_string($subValue)) {
                    continue;
                }
                $value[$subKey] = $this->prefixWithDirConstantIfExistingPath($subValue);
            }
        }

        $args = $this->argsNodeFactory->createFromValues([$parameterName, $value]);

        $parametersVariable = new Variable(VariableName::PARAMETERS);
        $methodCall = new MethodCall($parametersVariable, 'set', $args);

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
