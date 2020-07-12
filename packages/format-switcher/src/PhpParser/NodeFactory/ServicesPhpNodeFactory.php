<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
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
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    /**
     * @var ArgsNodeFactory
     */
    private $argsNodeFactory;

    public function __construct(CommonNodeFactory $commonNodeFactory, ArgsNodeFactory $argsNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->argsNodeFactory = $argsNodeFactory;
    }

    public function createServicesInit(): Expression
    {
        $servicesVariable = new Variable(VariableName::SERVICES);
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
        if (! is_array($exclude)) {
            $exclude = [$exclude];
        }

        $excludeValue = [];
        foreach ($exclude as $key => $singleExclude) {
            $excludeValue[$key] = $this->commonNodeFactory->createAbsoluteDirExpr($singleExclude);
        }

        $args = $this->argsNodeFactory->createFromValues([$excludeValue]);
        $excludeMethodCall = new MethodCall($servicesLoadMethodCall, self::EXCLUDE, $args);

        return new Expression($excludeMethodCall);
    }

    private function createServicesLoadMethodCall(string $serviceKey, $serviceValues): MethodCall
    {
        $servicesVariable = new Variable(VariableName::SERVICES);

        $resource = $serviceValues['resource'];

        $args = [];
        $args[] = new Arg(new String_($serviceKey));
        $args[] = new Arg($this->commonNodeFactory->createAbsoluteDirExpr($resource));

        return new MethodCall($servicesVariable, 'load', $args);
    }
}
