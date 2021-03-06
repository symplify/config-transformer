<?php

declare (strict_types=1);
namespace ConfigTransformer202107130\Symplify\PhpConfigPrinter\ExprResolver;

use ConfigTransformer202107130\Nette\Utils\Strings;
use ConfigTransformer202107130\PhpParser\BuilderHelpers;
use ConfigTransformer202107130\PhpParser\Node\Arg;
use ConfigTransformer202107130\PhpParser\Node\Expr;
use ConfigTransformer202107130\PhpParser\Node\Expr\ClassConstFetch;
use ConfigTransformer202107130\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer202107130\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer202107130\PhpParser\Node\Scalar\String_;
use ConfigTransformer202107130\Symplify\Astral\ValueObject\AttributeKey;
use ConfigTransformer202107130\Symplify\PhpConfigPrinter\Configuration\SymfonyFunctionNameProvider;
use ConfigTransformer202107130\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use ConfigTransformer202107130\Symplify\PhpConfigPrinter\NodeFactory\ConstantNodeFactory;
use ConfigTransformer202107130\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
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
    /**
     * @var \Symplify\PhpConfigPrinter\Configuration\SymfonyFunctionNameProvider
     */
    private $symfonyFunctionNameProvider;
    public function __construct(\ConfigTransformer202107130\Symplify\PhpConfigPrinter\NodeFactory\ConstantNodeFactory $constantNodeFactory, \ConfigTransformer202107130\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory, \ConfigTransformer202107130\Symplify\PhpConfigPrinter\Configuration\SymfonyFunctionNameProvider $symfonyFunctionNameProvider)
    {
        $this->constantNodeFactory = $constantNodeFactory;
        $this->commonNodeFactory = $commonNodeFactory;
        $this->symfonyFunctionNameProvider = $symfonyFunctionNameProvider;
    }
    public function resolve(string $value, bool $skipServiceReference, bool $skipClassesToConstantReference) : \ConfigTransformer202107130\PhpParser\Node\Expr
    {
        if ($value === '') {
            return new \ConfigTransformer202107130\PhpParser\Node\Scalar\String_($value);
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
            $args = [new \ConfigTransformer202107130\PhpParser\Node\Arg($expr)];
            return new \ConfigTransformer202107130\PhpParser\Node\Expr\FuncCall(new \ConfigTransformer202107130\PhpParser\Node\Name\FullyQualified(\ConfigTransformer202107130\Symplify\PhpConfigPrinter\ValueObject\FunctionName::EXPR), $args);
        }
        // is service reference
        if (\strncmp($value, '@', \strlen('@')) === 0 && !$this->isFilePath($value)) {
            $refOrServiceFunctionName = $this->symfonyFunctionNameProvider->provideRefOrService();
            return $this->resolveServiceReferenceExpr($value, $skipServiceReference, $refOrServiceFunctionName);
        }
        return \ConfigTransformer202107130\PhpParser\BuilderHelpers::normalizeValue($value);
    }
    private function keepNewline(string $value) : \ConfigTransformer202107130\PhpParser\Node\Scalar\String_
    {
        $string = new \ConfigTransformer202107130\PhpParser\Node\Scalar\String_($value);
        $string->setAttribute(\ConfigTransformer202107130\Symplify\Astral\ValueObject\AttributeKey::KIND, \ConfigTransformer202107130\PhpParser\Node\Scalar\String_::KIND_DOUBLE_QUOTED);
        return $string;
    }
    private function isFilePath(string $value) : bool
    {
        return (bool) \ConfigTransformer202107130\Nette\Utils\Strings::match($value, self::TWIG_HTML_XML_SUFFIX_REGEX);
    }
    /**
     * @return \PhpParser\Node\Scalar\String_|\PhpParser\Node\Expr\ClassConstFetch
     */
    private function resolveClassType(bool $skipClassesToConstantReference, string $value)
    {
        if ($skipClassesToConstantReference) {
            return new \ConfigTransformer202107130\PhpParser\Node\Scalar\String_($value);
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
    private function resolveServiceReferenceExpr(string $value, bool $skipServiceReference, string $functionName) : \ConfigTransformer202107130\PhpParser\Node\Expr
    {
        $value = \ltrim($value, '@');
        $expr = $this->resolve($value, $skipServiceReference, \false);
        if ($skipServiceReference) {
            return $expr;
        }
        $args = [new \ConfigTransformer202107130\PhpParser\Node\Arg($expr)];
        return new \ConfigTransformer202107130\PhpParser\Node\Expr\FuncCall(new \ConfigTransformer202107130\PhpParser\Node\Name\FullyQualified($functionName), $args);
    }
}
