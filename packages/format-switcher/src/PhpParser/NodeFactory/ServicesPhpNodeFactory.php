<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;

final class ServicesPhpNodeFactory
{
    /**
     * @var string
     */
    private const SERVICES_VARIABLE_NAME = 'services';

    /**
     * @var PhpNodeFactory
     */
    private $phpNodeFactory;

    public function __construct(PhpNodeFactory $phpNodeFactory)
    {
        $this->phpNodeFactory = $phpNodeFactory;
    }

    public function createServicesLoadMethodCall(string $serviceKey, $serviceValues): MethodCall
    {
        $servicesVariable = new Variable(self::SERVICES_VARIABLE_NAME);

        $resource = $serviceValues['resource'];

        $args = [];
        $args[] = new Arg(new String_($serviceKey));
        $args[] = new Arg($this->phpNodeFactory->createAbsoluteDirExpr($resource));

        return new MethodCall($servicesVariable, 'load', $args);
    }
}
