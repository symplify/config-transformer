<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\ServiceKeyYamlToPhpFactory;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service\AutoBindNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use Migrify\ConfigTransformer\FormatSwitcher\Yaml\YamlCommentPreserver;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;

/**
 * Handles this part:
 *
 * services:
 *     _defaults: <---
 */
final class DefaultsServiceKeyYamlToPhpFactory implements ServiceKeyYamlToPhpFactoryInterface
{
    /**
     * @var AutoBindNodeFactory
     */
    private $autoBindNodeFactory;

    /**
     * @var YamlCommentPreserver
     */
    private $yamlCommentPreserver;

    public function __construct(AutoBindNodeFactory $autoBindNodeFactory, YamlCommentPreserver $yamlCommentPreserver)
    {
        $this->autoBindNodeFactory = $autoBindNodeFactory;
        $this->yamlCommentPreserver = $yamlCommentPreserver;
    }

    public function convertYamlToNode($key, $yaml): Node
    {
        foreach ($yaml as $subKey => $subValue) {
            if ($this->yamlCommentPreserver->isCommentKey($subKey)) {
                $this->yamlCommentPreserver->collectComment($subValue);
                unset($yaml[$subKey]);
                continue;
            }
        }

        $methodCall = new MethodCall($this->createServicesVariable(), 'defaults');
        $methodCall = $this->autoBindNodeFactory->createAutoBindCalls($yaml, $methodCall);

        $expression = new Expression($methodCall);

        $this->yamlCommentPreserver->decorateNodeWithComments($expression);

        return $expression;
    }

    public function isMatch($key, $values): bool
    {
        return $key === YamlKey::_DEFAULTS;
    }

    private function createServicesVariable(): Variable
    {
        return new Variable(VariableName::SERVICES);
    }
}
