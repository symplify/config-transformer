<?php

declare (strict_types=1);
namespace ConfigTransformer202205300\Symplify\PhpConfigPrinter\Printer;

use ConfigTransformer202205300\Nette\Utils\Strings;
use ConfigTransformer202205300\PhpParser\Node;
use ConfigTransformer202205300\PhpParser\Node\Expr\Array_;
use ConfigTransformer202205300\PhpParser\Node\Expr\MethodCall;
use ConfigTransformer202205300\PhpParser\Node\Scalar\LNumber;
use ConfigTransformer202205300\PhpParser\Node\Stmt\Declare_;
use ConfigTransformer202205300\PhpParser\Node\Stmt\DeclareDeclare;
use ConfigTransformer202205300\PhpParser\Node\Stmt\Nop;
use ConfigTransformer202205300\PhpParser\PrettyPrinter\Standard;
use ConfigTransformer202205300\Symplify\PhpConfigPrinter\NodeTraverser\ImportFullyQualifiedNamesNodeTraverser;
use ConfigTransformer202205300\Symplify\PhpConfigPrinter\Printer\NodeDecorator\EmptyLineNodeDecorator;
final class PhpParserPhpConfigPrinter extends \ConfigTransformer202205300\PhpParser\PrettyPrinter\Standard
{
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
     * @var \Symplify\PhpConfigPrinter\NodeTraverser\ImportFullyQualifiedNamesNodeTraverser
     */
    private $importFullyQualifiedNamesNodeTraverser;
    /**
     * @var \Symplify\PhpConfigPrinter\Printer\NodeDecorator\EmptyLineNodeDecorator
     */
    private $emptyLineNodeDecorator;
    public function __construct(\ConfigTransformer202205300\Symplify\PhpConfigPrinter\NodeTraverser\ImportFullyQualifiedNamesNodeTraverser $importFullyQualifiedNamesNodeTraverser, \ConfigTransformer202205300\Symplify\PhpConfigPrinter\Printer\NodeDecorator\EmptyLineNodeDecorator $emptyLineNodeDecorator)
    {
        $this->importFullyQualifiedNamesNodeTraverser = $importFullyQualifiedNamesNodeTraverser;
        $this->emptyLineNodeDecorator = $emptyLineNodeDecorator;
        parent::__construct();
    }
    /**
     * @param Node\Stmt[] $stmts
     */
    public function prettyPrintFile(array $stmts) : string
    {
        $stmts = $this->importFullyQualifiedNamesNodeTraverser->traverseNodes($stmts);
        $this->emptyLineNodeDecorator->decorate($stmts);
        // adds "declare(strict_types=1);" to every file
        $stmts = $this->prependStrictTypesDeclare($stmts);
        $printedContent = parent::prettyPrintFile($stmts);
        // remove trailing spaces
        $printedContent = \ConfigTransformer202205300\Nette\Utils\Strings::replace($printedContent, self::START_WITH_SPACE_REGEX, "\n");
        // remove space before " :" in main closure
        $printedContent = \ConfigTransformer202205300\Nette\Utils\Strings::replace($printedContent, self::VOID_AFTER_FUNC_REGEX, '): void');
        // remove space between declare strict types
        $printedContent = \ConfigTransformer202205300\Nette\Utils\Strings::replace($printedContent, self::DECLARE_SPACE_STRICT_REGEX, 'declare(strict');
        return $printedContent . \PHP_EOL;
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
        return "'" . \ConfigTransformer202205300\Nette\Utils\Strings::replace($string, self::QUOTE_SLASH_REGEX, '\\\\$0') . "'";
    }
    protected function pExpr_Array(\ConfigTransformer202205300\PhpParser\Node\Expr\Array_ $array) : string
    {
        $array->setAttribute(self::KIND, \ConfigTransformer202205300\PhpParser\Node\Expr\Array_::KIND_SHORT);
        return parent::pExpr_Array($array);
    }
    protected function pExpr_MethodCall(\ConfigTransformer202205300\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        $printedMethodCall = parent::pExpr_MethodCall($methodCall);
        return $this->indentFluentCallToNewline($printedMethodCall);
    }
    private function indentFluentCallToNewline(string $content) : string
    {
        $nextCallIndentReplacement = ')' . \PHP_EOL . \ConfigTransformer202205300\Nette\Utils\Strings::indent('->', 8, ' ');
        return \ConfigTransformer202205300\Nette\Utils\Strings::replace($content, '#\\)->#', $nextCallIndentReplacement);
    }
    /**
     * @param Node[] $stmts
     * @return Node[]
     */
    private function prependStrictTypesDeclare(array $stmts) : array
    {
        $strictTypesDeclare = $this->createStrictTypesDeclare();
        return \array_merge([$strictTypesDeclare, new \ConfigTransformer202205300\PhpParser\Node\Stmt\Nop()], $stmts);
    }
    private function createStrictTypesDeclare() : \ConfigTransformer202205300\PhpParser\Node\Stmt\Declare_
    {
        $declareDeclare = new \ConfigTransformer202205300\PhpParser\Node\Stmt\DeclareDeclare('strict_types', new \ConfigTransformer202205300\PhpParser\Node\Scalar\LNumber(1));
        return new \ConfigTransformer202205300\PhpParser\Node\Stmt\Declare_([$declareDeclare]);
    }
}
