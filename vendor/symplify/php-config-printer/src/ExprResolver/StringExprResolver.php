<?php

declare (strict_types=1);
namespace ConfigTransformer202206077\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer202206077\Nette\Utils\Strings;
use ConfigTransformer202206077\PhpParser\BuilderHelpers;
use ConfigTransformer202206077\PhpParser\Node\Arg;
use ConfigTransformer202206077\PhpParser\Node\Expr;
use ConfigTransformer202206077\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer202206077\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202206077\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer202206077\PhpParser\Node\Scalar\String_;
use ConfigTransformer202206077\Symplify\Astral\ValueObject\AttributeKey;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\NodeFactory\ConstantNodeFactory;
use ConfigTransformer202206077\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class StringExprResolver
{
    /**
     * @see https://regex101.com/r/laf2wR/1
     * @var string
     */
    private const TWIG_HTML_XML_SUFFIX_REGEX = '#\\.(twig|html|xml)$#';
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\ConstantNodeFactory
     */
    private $constantNodeFactory;
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory
     */
    private $commonNodeFactory;
    public function __construct(ConstantNodeFactory $constantNodeFactory, CommonNodeFactory $commonNodeFactory)
    {
        $this->constantNodeFactory = $constantNodeFactory;
        $this->commonNodeFactory = $commonNodeFactory;
    }
    public function resolve(string $value, bool $skipServiceReference, bool $skipClassesToConstantReference) : Expr
    {
        if ($value === '') {
            return new String_($value);
        }
        $constFetch = $this->constantNodeFactory->createConstantIfValue($value);
        if ($constFetch !== null) {
            return $constFetch;
        }
        // do not print "\n" as empty space, but use string value instead
        if (\in_array($value, ["\r", "\n", "\r\n"], \true)) {
            return $this->keepNewline($value);
        }
        $value = \ltrim($value, '\\');
        if ($this->isClassType($value)) {
            return $this->resolveClassType($skipClassesToConstantReference, $value);
        }
        if (\strncmp($value, '@=', \strlen('@=')) === 0) {
            $value = \ltrim($value, '@=');
            $expr = $this->resolve($value, $skipServiceReference, $skipClassesToConstantReference);
            $args = [new Arg($expr)];
            return new FuncCall(new FullyQualified(FunctionName::EXPR), $args);
        }
        // is service reference
        if (\strncmp($value, '@', \strlen('@')) === 0 && !$this->isFilePath($value)) {
            return $this->resolveServiceReferenceExpr($value, $skipServiceReference, FunctionName::SERVICE);
        }
        return BuilderHelpers::normalizeValue($value);
    }
    private function keepNewline(string $value) : String_
    {
        $string = new String_($value);
        $string->setAttribute(AttributeKey::KIND, String_::KIND_DOUBLE_QUOTED);
        return $string;
    }
    private function isFilePath(string $value) : bool
    {
        return (bool) Strings::match($value, self::TWIG_HTML_XML_SUFFIX_REGEX);
    }
    /**
     * @return \PhpParser\Node\Scalar\String_|\PhpParser\Node\Expr\ClassConstFetch
     */
    private function resolveClassType(bool $skipClassesToConstantReference, string $value)
    {
        if ($skipClassesToConstantReference) {
            return new String_($value);
        }
        return $this->commonNodeFactory->createClassReference($value);
    }
    private function isClassType(string $value) : bool
    {
        if (!\ctype_upper($value[0])) {
            return \false;
        }
        if (\class_exists($value)) {
            return \true;
        }
        return \interface_exists($value);
    }
    /**
     * @param FunctionName::* $functionName
     */
    private function resolveServiceReferenceExpr(string $value, bool $skipServiceReference, string $functionName) : Expr
    {
        $value = \ltrim($value, '@');
        $expr = $this->resolve($value, $skipServiceReference, \false);
        if ($skipServiceReference) {
            return $expr;
        }
        $args = [new Arg($expr)];
        return new FuncCall(new FullyQualified($functionName), $args);
    }
}
