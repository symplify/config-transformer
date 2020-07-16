<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\VariableName;
use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

final class ClosureNodeFactory
{
    /**
     * @param Node[] $stmts
     */
    public function createClosureFromStmts(array $stmts): Closure
    {
        $containerConfiguratorVariable = new Variable(VariableName::CONTAINER_CONFIGURATOR);
        $param = new Param($containerConfiguratorVariable, null, new FullyQualified(ContainerConfigurator::class));

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
