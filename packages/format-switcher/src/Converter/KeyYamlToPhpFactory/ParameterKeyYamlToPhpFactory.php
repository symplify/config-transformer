<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\KeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\KeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\PhpNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use Migrify\ConfigTransformer\FormatSwitcher\Yaml\YamlCommentPreserver;
use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;

/**
 * Handles this part:
 *
 * parameters: <---
 */
final class ParameterKeyYamlToPhpFactory implements KeyYamlToPhpFactoryInterface
{
    /**
     * @var PhpNodeFactory
     */
    private $phpNodeFactory;

    /**
     * @var YamlCommentPreserver
     */
    private $yamlCommentPreserver;

    public function __construct(PhpNodeFactory $phpNodeFactory, YamlCommentPreserver $yamlCommentPreserver)
    {
        $this->phpNodeFactory = $phpNodeFactory;
        $this->yamlCommentPreserver = $yamlCommentPreserver;
    }

    public function getKey(): string
    {
        return YamlKey::PARAMETERS;
    }

    /**
     * @param mixed[] $yaml
     * @return Node[]
     */
    public function convertYamlToNodes(array $yaml): array
    {
        if (count($yaml) === 0) {
            return [];
        }

        $nodes = [];
        $nodes[] = $this->createParametersInit();

        foreach ($yaml as $parameterName => $value) {
            if ($this->yamlCommentPreserver->isCommentKey($parameterName)) {
                $this->yamlCommentPreserver->collectComment($value);
                continue;
            }

            /** @var string $parameterName */
            $parameterMethodCall = $this->phpNodeFactory->createParameterSetMethodCall($parameterName, $value);
            $this->yamlCommentPreserver->decorateNodeWithComments($parameterMethodCall);

            $nodes[] = $parameterMethodCall;
        }

        return $nodes;
    }

    private function createParametersInit(): Expression
    {
        $servicesVariable = new Variable(YamlKey::PARAMETERS);
        $containerConfiguratorVariable = new Variable(VariableName::CONTAINER_CONFIGURATOR);

        $assign = new Assign($servicesVariable, new MethodCall($containerConfiguratorVariable, YamlKey::PARAMETERS));

        return new Expression($assign);
    }
}
