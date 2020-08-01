<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\CaseConverter;

use Migrify\ConfigTransformer\FeatureShifter\ValueObject\YamlKey;
use Migrify\ConfigTransformer\FormatSwitcher\Contract\CaseConverterInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\Service\AutoBindNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\MethodName;
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
final class ServicesDefaultsCaseConverter implements CaseConverterInterface
{
    /**
     * @var AutoBindNodeFactory
     */
    private $autoBindNodeFactory;

    public function __construct(AutoBindNodeFactory $autoBindNodeFactory)
    {
        $this->autoBindNodeFactory = $autoBindNodeFactory;
    }

    public function convertToMethodCall($key, $values): Expression
    {
        $methodCall = new MethodCall($this->createServicesVariable(), MethodName::DEFAULTS);
        $methodCall = $this->autoBindNodeFactory->createAutoBindCalls(
            $values,
            $methodCall,
            AutoBindNodeFactory::TYPE_DEFAULTS
        );

        return new Expression($methodCall);
    }

    public function match(string $rootKey, $key, $values): bool
    {
        if ($rootKey !== YamlKey::SERVICES) {
            return false;
        }

        return $key === YamlKey::_DEFAULTS;
    }

    private function createServicesVariable(): Variable
    {
        return new Variable(VariableName::SERVICES);
    }
}
