<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\Builder\Param;
use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Identifier;

final class ClosureNodeFactory
{
    /**
     * @param Node[] $stmts
     */
    public function createClosureFromStmts(array $stmts): Closure
    {
        $paramBuilder = new Param(VariableName::CONTAINER_CONFIGURATOR);
        $paramBuilder->setType('ContainerConfigurator');

        $param = $paramBuilder->getNode();

        $closure = new Closure([
            'params' => [$param],
            'stmts' => $stmts,
            'static' => true,
        ]);

        // is PHP 7.1 → add "void"
        if (version_compare(PHP_VERSION, '7.1.0') >= 0) {
            $closure->returnType = new Identifier('void');
        }

        return $closure;
    }
}
