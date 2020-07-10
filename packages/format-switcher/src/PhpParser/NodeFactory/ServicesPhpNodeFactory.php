<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\BuilderHelpers;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Expression;

final class ServicesPhpNodeFactory
{
    /**
     * @var string
     */
    private const EXCLUDE = 'exclude';

    /**
     * @var PhpNodeFactory
     */
    private $phpNodeFactory;

    public function __construct(PhpNodeFactory $phpNodeFactory)
    {
        $this->phpNodeFactory = $phpNodeFactory;
    }

    public function createServicesInit(): Expression
    {
        $servicesVariable = $this->createServicesVariable();
        $containerConfiguratorVariable = new Variable(VariableName::CONTAINER_CONFIGURATOR);

        $assign = new Assign($servicesVariable, new MethodCall($containerConfiguratorVariable, 'services'));

        return new Expression($assign);
    }

    public function createResource(string $serviceKey, array $serviceValues): Expression
    {
        $servicesLoadMethodCall = $this->createServicesLoadMethodCall($serviceKey, $serviceValues);

        if (! isset($serviceValues[self::EXCLUDE])) {
            return new Expression($servicesLoadMethodCall);
        }

        $exclude = $serviceValues[self::EXCLUDE];
        $excludeMethodCall = new MethodCall($servicesLoadMethodCall, self::EXCLUDE);

        $excludeValue = [];
        foreach ($exclude as $key => $singleExclude) {
            $excludeValue[$key] = $this->phpNodeFactory->createAbsoluteDirExpr($singleExclude);
        }

        $excludeValue = BuilderHelpers::normalizeValue($excludeValue);
        $excludeMethodCall->args[] = new Arg($excludeValue);

        return new Expression($excludeMethodCall);
    }

    public function createServiceDefaults(array $serviceValues): Expression
    {
        $methodCall = new MethodCall($this->createServicesVariable(), 'defaults');

        foreach (array_keys($serviceValues) as $key) {
            if (in_array($key, ['autowire', 'autoconfigure', 'public'], true)) {
                $methodCall = new MethodCall($methodCall, $key);
            }
        }

        return new Expression($methodCall);
    }

    private function createServicesLoadMethodCall(string $serviceKey, $serviceValues): MethodCall
    {
        $servicesVariable = $this->createServicesVariable();

        $resource = $serviceValues['resource'];

        $args = [];
        $args[] = new Arg(new String_($serviceKey));
        $args[] = new Arg($this->phpNodeFactory->createAbsoluteDirExpr($resource));

        return new MethodCall($servicesVariable, 'load', $args);
    }

    private function createServicesVariable(): Variable
    {
        return new Variable(VariableName::SERVICES);
    }
}
