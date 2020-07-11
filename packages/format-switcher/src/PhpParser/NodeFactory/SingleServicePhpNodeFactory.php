<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use Migrify\ConfigTransformer\Naming\ClassNaming;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Expression;

final class SingleServicePhpNodeFactory
{
    /**
     * @var ClassNaming
     */
    private $classNaming;

    public function __construct(ClassNaming $classNaming)
    {
        $this->classNaming = $classNaming;
    }

    public function createSetService(string $serviceKey): Expression
    {
        $classReference = $this->createShortClassReference($serviceKey);
        $setMethodCall = new MethodCall(new Variable(VariableName::SERVICES), 'set', [new Arg($classReference)]);

        return new Expression($setMethodCall);
    }

    private function createShortClassReference(string $className): ClassConstFetch
    {
        $shortClassName = $this->classNaming->getShortName($className);

        return new ClassConstFetch(new Name($shortClassName), 'class');
    }
}
