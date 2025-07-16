<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Printer;

use ConfigTransformerPrefix202507\Nette\Utils\Strings;
use ConfigTransformerPrefix202507\PhpParser\Node;
use ConfigTransformerPrefix202507\PhpParser\Node\Expr\Array_;
use ConfigTransformerPrefix202507\PhpParser\Node\Expr\MethodCall;
use ConfigTransformerPrefix202507\PhpParser\Node\Scalar\LNumber;
use ConfigTransformerPrefix202507\PhpParser\Node\Stmt;
use ConfigTransformerPrefix202507\PhpParser\Node\Stmt\Declare_;
use ConfigTransformerPrefix202507\PhpParser\Node\Stmt\DeclareDeclare;
use ConfigTransformerPrefix202507\PhpParser\Node\Stmt\Nop;
use ConfigTransformerPrefix202507\PhpParser\NodeTraverser;
use ConfigTransformerPrefix202507\PhpParser\PrettyPrinter\Standard;
use Symplify\PhpConfigPrinter\Contract\NodeVisitor\PrePrintNodeVisitorInterface;
use Symplify\PhpConfigPrinter\NodeTraverser\ImportFullyQualifiedNamesNodeTraverser;
use Symplify\PhpConfigPrinter\Printer\NodeDecorator\EmptyLineNodeDecorator;
final class PhpParserPhpConfigPrinter extends Standard
{
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\NodeTraverser\ImportFullyQualifiedNamesNodeTraverser
     */
    private $importFullyQualifiedNamesNodeTraverser;
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\Printer\NodeDecorator\EmptyLineNodeDecorator
     */
    private $emptyLineNodeDecorator;
    /**
     * @var PrePrintNodeVisitorInterface[]
     * @readonly
     */
    private $prePrintNodeVisitors;
    /**
     * @see https://regex101.com/r/qYtAPy/1
     * @var string
     */
    private const QUOTE_SLASH_REGEX = "#'|\\\\(?=[\\\\']|\$)#";
    /**
     * @see https://regex101.com/r/u0iUrM/1
     * @var string
     */
    private const START_WITH_SPACE_REGEX = '#^[ ]+\\n#m';
    /**
     * @see https://regex101.com/r/jJc7n3/1
     * @var string
     */
    private const VOID_AFTER_FUNC_REGEX = '#\\) : void#';
    /**
     * @var string
     */
    private const KIND = 'kind';
    /**
     * @see https://regex101.com/r/YYTPz6/1
     * @var string
     */
    private const DECLARE_SPACE_STRICT_REGEX = '#declare \\(strict#';
    /**
     * @param PrePrintNodeVisitorInterface[] $prePrintNodeVisitors
     */
    public function __construct(ImportFullyQualifiedNamesNodeTraverser $importFullyQualifiedNamesNodeTraverser, EmptyLineNodeDecorator $emptyLineNodeDecorator, iterable $prePrintNodeVisitors)
    {
        $this->importFullyQualifiedNamesNodeTraverser = $importFullyQualifiedNamesNodeTraverser;
        $this->emptyLineNodeDecorator = $emptyLineNodeDecorator;
        $this->prePrintNodeVisitors = $prePrintNodeVisitors;
        parent::__construct();
    }
    /**
     * @param Stmt[] $stmts
     */
    public function prettyPrintFile(array $stmts) : string
    {
        if ($this->prePrintNodeVisitors !== []) {
            $nodeTraverser = new NodeTraverser();
            foreach ($this->prePrintNodeVisitors as $prePrintNodeVisitor) {
                $nodeTraverser->addVisitor($prePrintNodeVisitor);
            }
            $nodeTraverser->traverse($stmts);
        }
        $stmts = $this->importFullyQualifiedNamesNodeTraverser->traverseNodes($stmts);
        $this->emptyLineNodeDecorator->decorate($stmts);
        // adds "declare(strict_types=1);" to every file
        $stmts = $this->prependStrictTypesDeclare($stmts);
        $printedContent = parent::prettyPrintFile($stmts);
        // remove trailing spaces
        $printedContent = Strings::replace($printedContent, self::START_WITH_SPACE_REGEX, "\n");
        // remove space before " :" in main closure
        $printedContent = Strings::replace($printedContent, self::VOID_AFTER_FUNC_REGEX, '): void');
        // remove space between declare strict types
        $printedContent = Strings::replace($printedContent, self::DECLARE_SPACE_STRICT_REGEX, 'declare(strict');
        return $printedContent . \PHP_EOL;
    }
    /**
     * Inspired by https://github.com/rectorphp/rector-src/pull/3271/files
     *
     * Always print array items with newlines to make look nice out of the oven.
     */
    protected function pExpr_Array(Array_ $array) : string
    {
        // short always :)
        $array->setAttribute(self::KIND, Array_::KIND_SHORT);
        $printedArray = '[';
        $printedArray .= $this->pCommaSeparatedMultiline($array->items, \true);
        return $printedArray . ($this->nl . ']');
    }
    /**
     * Do not preslash all slashes (parent behavior), but only those:
     * - followed by "\"
     * - by "'" - or the end of the string
     *
     * Prevents `Vendor\Class` => `Vendor\\Class`.
     */
    protected function pSingleQuotedString(string $string) : string
    {
        return "'" . Strings::replace($string, self::QUOTE_SLASH_REGEX, '\\\\$0') . "'";
    }
    protected function pExpr_MethodCall(MethodCall $methodCall) : string
    {
        $printedMethodCall = parent::pExpr_MethodCall($methodCall);
        return $this->indentFluentCallToNewline($printedMethodCall);
    }
    private function indentFluentCallToNewline(string $content) : string
    {
        $nextCallIndentReplacement = ')' . \PHP_EOL . Strings::indent('->', 8, ' ');
        return Strings::replace($content, '#\\)->#', $nextCallIndentReplacement);
    }
    /**
     * @param Node[] $stmts
     * @return Node[]
     */
    private function prependStrictTypesDeclare(array $stmts) : array
    {
        $strictTypesDeclare = $this->createStrictTypesDeclare();
        return \array_merge([$strictTypesDeclare, new Nop()], $stmts);
    }
    private function createStrictTypesDeclare() : Declare_
    {
        $declareDeclare = new DeclareDeclare('strict_types', new LNumber(1));
        return new Declare_([$declareDeclare]);
    }
}
