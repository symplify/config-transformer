<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Param;

final class ClosureNodeFactory
{
    /**
     * @param Node[] $stmts
     */
    public function createClosureFromStmts(array $stmts, string $variableName, string $type): Closure
    {
        $containerConfiguratorVariable = new Variable($variableName);
        $param = new Param($containerConfiguratorVariable, null, new FullyQualified($type));

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
