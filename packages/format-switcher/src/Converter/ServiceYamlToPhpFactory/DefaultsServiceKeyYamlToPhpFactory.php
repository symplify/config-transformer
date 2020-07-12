<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Converter\ServiceYamlToPhpFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Contract\Converter\ServiceKeyYamlToPhpFactoryInterface;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\ArgsNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory\CommonNodeFactory;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\Node\Arg;
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
     * @var string
     */
    private const BIND = 'bind';

    /**
     * @var string
     */
    private const DEFAULTS = '_defaults';

    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    public function __construct(ArgsNodeFactory $argsNodeFactory, CommonNodeFactory $commonNodeFactory)
    {
        $this->argsNodeFactory = $argsNodeFactory;
        $this->commonNodeFactory = $commonNodeFactory;
    }

    public function convertYamlToNodes($key, $serviceValues): array
    {
        $methodCall = new MethodCall($this->createServicesVariable(), 'defaults');

        foreach ($serviceValues as $key => $value) {
            if (in_array($key, ['autowire', 'autoconfigure', 'public'], true)) {
                $methodCall = new MethodCall($methodCall, $key);
                if ($value === false) {
                    $methodCall->args[] = new Arg($this->commonNodeFactory->createFalse());
                }
            }

            if ($key === self::BIND) {
                $methodCall = $this->createBindMethodCall($methodCall, $serviceValues[self::BIND]);
            }
        }

        return [new Expression($methodCall)];
    }

    public function isMatch($key, $values): bool
    {
        return $key === self::DEFAULTS;
    }

    private function createServicesVariable(): Variable
    {
        return new Variable(VariableName::SERVICES);
    }

    private function createBindMethodCall(MethodCall $methodCall, array $bindValues): MethodCall
    {
        foreach ($bindValues as $key => $value) {
            $args = $this->argsNodeFactory->createFromValues([$key, $value]);
            $methodCall = new MethodCall($methodCall, self::BIND, $args);
        }

        return $methodCall;
    }
}
