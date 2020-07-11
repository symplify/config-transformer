<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\Printer;

use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeTraverser\ImportFullyQualifiedNamesNodeTraverser;
use Nette\Utils\Strings;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Nop;
use PhpParser\NodeFinder;
use PhpParser\PrettyPrinter\Standard;

final class FluentPhpConfigurationPrinter extends Standard
{
    /**
     * @var string
     */
    private const EOL_CHAR = "\n";

    /**
     * @var ImportFullyQualifiedNamesNodeTraverser
     */
    private $importFullyQualifiedNamesNodeTraverser;

    /**
     * @var NodeFinder
     */
    private $betterNodeFinder;

    public function __construct(
        ImportFullyQualifiedNamesNodeTraverser $importFullyQualifiedNamesNodeTraverser,
        NodeFinder $nodeFinder
    ) {
        $this->importFullyQualifiedNamesNodeTraverser = $importFullyQualifiedNamesNodeTraverser;
        $this->betterNodeFinder = $nodeFinder;

        parent::__construct();
    }

    public function prettyPrintFile(array $stmts): string
    {
        $stmts = $this->importFullyQualifiedNamesNodeTraverser->traverseNodes($stmts);

        $stmts = $this->completeEmptyLines($stmts);

        $printedContent = parent::prettyPrintFile($stmts);

        // remove trailing spaces
        $printedContent = Strings::replace($printedContent, '#^[ ]+\n#m', "\n");

        // remove space before " :" in main closure
        $printedContent = Strings::replace(
            $printedContent,
            '#containerConfigurator\) : void#',
            'containerConfigurator): void'
        );

        return $printedContent . self::EOL_CHAR;
    }

    /**
     * Do not preslash all slashes (parent behavior), but only those:
     *
     * - followed by "\"
     * - by "'"
     * - or the end of the string
     *
     * Prevents `Vendor\Class` => `Vendor\\Class`.
     */
    protected function pSingleQuotedString(string $string): string
    {
        return "'" . Strings::replace($string, "#'|\\\\(?=[\\\\']|$)#", '\\\\$0') . "'";
    }

    protected function pExpr_Array(Array_ $array): string
    {
        $array->setAttribute('kind', Array_::KIND_SHORT);

        return parent::pExpr_Array($array);
    }

    protected function pExpr_MethodCall(MethodCall $methodCall): string
    {
        $printedMethodCall = parent::pExpr_MethodCall($methodCall);
        return $this->indentFluentCallToNewline($printedMethodCall);
    }

    private function indentFluentCallToNewline(string $content): string
    {
        $nextCallIndentReplacement = ')' . PHP_EOL . Strings::indent('->', 8, ' ');
        return Strings::replace($content, '#\)->#', $nextCallIndentReplacement);
    }

    /**
     * @todo decouple to own service
     */
    private function completeEmptyLines(array $stmts): array
    {
        /** @var Closure|null $closure */
        $closure = $this->betterNodeFinder->findFirstInstanceOf($stmts, Closure::class);
        if ($closure === null) {
            return $stmts;
        }

        $newStmts = [];

        foreach ($closure->stmts as $key => $closureStmt) {
            if ($key === 0 || ! $closureStmt instanceof Expression) {
                $newStmts[] = $closureStmt;
                continue;
            }

            $closureStmtExpr = $closureStmt->expr;

            // before each assign
            if ($closureStmtExpr instanceof Assign) {
                $newStmts[] = new Nop();
                $newStmts[] = $closureStmt;
                continue;
            }

            // before each chained method call
            // is standalone method call or first in the chain call
            if ($closureStmtExpr instanceof MethodCall) {
                $newStmts[] = new Nop();
                $newStmts[] = $closureStmt;
                continue;
            }

            $newStmts[] = $closureStmt;
        }

        $closure->stmts = $newStmts;

        return $stmts;
    }
}
