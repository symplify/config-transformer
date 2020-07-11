<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Expression;

final class SingleServicePhpNodeFactory
{
    /**
     * @var CommonFactory
     */
    private $commonFactory;

    public function __construct(CommonFactory $commonFactory)
    {
        $this->commonFactory = $commonFactory;
    }

    public function createSetService(string $serviceKey): Expression
    {
        $classReference = $this->commonFactory->createShortClassReference($serviceKey);
        $setMethodCall = new MethodCall(new Variable(VariableName::SERVICES), 'set', [new Arg($classReference)]);

        return new Expression($setMethodCall);
    }
}
