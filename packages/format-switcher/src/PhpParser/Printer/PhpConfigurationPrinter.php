<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\Printer;

use Migrify\ConfigTransformer\FormatSwitcher\Exception\ShouldNotHappenException;
use Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeTraverser\ImportFullyQualifiedNamesNodeTraverser;
use Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Declare_;
use PhpParser\Node\Stmt\DeclareDeclare;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Nop;
use PhpParser\NodeFinder;
use PhpParser\PrettyPrinter\Standard;

final class PhpConfigurationPrinter extends Standard
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
    private $nodeFinder;

    public function __construct(
        ImportFullyQualifiedNamesNodeTraverser $importFullyQualifiedNamesNodeTraverser,
        NodeFinder $nodeFinder
    ) {
        $this->importFullyQualifiedNamesNodeTraverser = $importFullyQualifiedNamesNodeTraverser;
        $this->nodeFinder = $nodeFinder;

        parent::__construct();
    }

    public function prettyPrintFile(array $stmts): string
    {
        $stmts = $this->importFullyQualifiedNames($stmts);
        $this->completeEmptyLines($stmts);

        // adds "declare(strict_types=1);" to every file
        $stmts = $this->prependStrictTypesDeclare($stmts);

        $printedContent = parent::prettyPrintFile($stmts);

        // remove trailing spaces
        $printedContent = Strings::replace($printedContent, '#^[ ]+\n#m', "\n");

        // remove space before " :" in main closure
        $printedContent = Strings::replace($printedContent, '#\) : void#', '): void');

        // remove space between declare strict types
        $printedContent = Strings::replace($printedContent, '#declare \(strict#', 'declare(strict');

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
    private function completeEmptyLines(array $stmts): void
    {
        /** @var Closure|null $closure */
        $closure = $this->nodeFinder->findFirstInstanceOf($stmts, Closure::class);
        if ($closure === null) {
            throw new ShouldNotHappenException();
        }

        $newStmts = [];

        foreach ($closure->stmts as $key => $closureStmt) {
            if ($this->shouldAddEmptyLineBeforeStatement($key, $closureStmt)) {
                $newStmts[] = new Nop();
            }

            $newStmts[] = $closureStmt;
        }

        $closure->stmts = $newStmts;
    }

    private function shouldAddEmptyLineBeforeStatement(int $key, Stmt $stmt): bool
    {
        // do not add space before first item
        if ($key === 0) {
            return false;
        }

        if (! $stmt instanceof Expression) {
            return false;
        }

        $expr = $stmt->expr;
        if ($expr instanceof Assign) {
            return true;
        }

        return $expr instanceof MethodCall;
    }

    /**
     * @param Node[] $stmts
     * @return Node[]
     */
    private function importFullyQualifiedNames(array $stmts): array
    {
        return $this->importFullyQualifiedNamesNodeTraverser->traverseNodes($stmts);
    }

    /**
     * @param Node[] $stmts
     * @return Node[]
     */
    private function prependStrictTypesDeclare(array $stmts): array
    {
        $strictTypesDeclare = $this->createStrictTypesDeclare();
        return array_merge([$strictTypesDeclare, new Nop()], $stmts);
    }

    private function createStrictTypesDeclare(): Declare_
    {
        $declareDeclare = new DeclareDeclare('strict_types', new LNumber(1));

        return new Declare_([$declareDeclare]);
    }
}
