<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\ServiceYamlToPhpFactory;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service\AutoBindNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
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

    public function __construct(AutoBindNodeFactory $autoBindNodeFactory)
    {
        $this->autoBindNodeFactory = $autoBindNodeFactory;
    }

    /**
     * @return Expression[]
     */
    public function convertYamlToNodes($key, $yaml): array
    {
        $methodCall = new MethodCall($this->createServicesVariable(), 'defaults');

        $methodCall = $this->autoBindNodeFactory->createAutoBindCalls($yaml, $methodCall);

        return [new Expression($methodCall)];
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
