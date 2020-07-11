<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;

final class SingleServicePhpNodeFactory
{
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    public function __construct(CommonNodeFactory $commonNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
    }

    public function createSetService(string $serviceKey): MethodCall
    {
        $classReference = $this->commonNodeFactory->createClassReference($serviceKey);

        return new MethodCall(new Variable(VariableName::SERVICES), 'set', [new Arg($classReference)]);
    }
}
