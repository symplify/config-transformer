<?php

declare (strict_types=1);
namespace ConfigTransformer2021082310\Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer2021082310\PhpParser\BuilderHelpers;
use ConfigTransformer2021082310\PhpParser\Node;
use ConfigTransformer2021082310\PhpParser\Node\Arg;
use ConfigTransformer2021082310\PhpParser\Node\Expr;
use ConfigTransformer2021082310\PhpParser\Node\Expr\Array_;
use ConfigTransformer2021082310\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer2021082310\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer2021082310\PhpParser\Node\Identifier;
use ConfigTransformer2021082310\PhpParser\Node\Name;
use ConfigTransformer2021082310\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer2021082310\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer2021082310\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException;
use ConfigTransformer2021082310\Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver;
use ConfigTransformer2021082310\Symplify\PhpConfigPrinter\ExprResolver\TaggedReturnsCloneResolver;
use ConfigTransformer2021082310\Symplify\PhpConfigPrinter\ExprResolver\TaggedServiceResolver;
use ConfigTransformer2021082310\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class ArgsNodeFactory
{
    /**
     * @var string
     */
    private const TAG_SERVICE = 'service';
    /**
     * @var string
     */
    private const TAG_RETURNS_CLONE = 'returns_clone';
    /**
     * @var bool
     */
    private $isPhpNamedArguments = \false;
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver
     */
    private $stringExprResolver;
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\TaggedReturnsCloneResolver
     */
    private $taggedReturnsCloneResolver;
    /**
     * @var \Symplify\PhpConfigPrinter\ExprResolver\TaggedServiceResolver
     */
    private $taggedServiceResolver;
    public function __construct(\ConfigTransformer2021082310\Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver $stringExprResolver, \ConfigTransformer2021082310\Symplify\PhpConfigPrinter\ExprResolver\TaggedReturnsCloneResolver $taggedReturnsCloneResolver, \ConfigTransformer2021082310\Symplify\PhpConfigPrinter\ExprResolver\TaggedServiceResolver $taggedServiceResolver)
    {
        $this->stringExprResolver = $stringExprResolver;
        $this->taggedReturnsCloneResolver = $taggedReturnsCloneResolver;
        $this->taggedServiceResolver = $taggedServiceResolver;
        $this->isPhpNamedArguments = \PHP_VERSION_ID >= 80000;
    }
    /**
     * @return Arg[]
     */
    public function createFromValuesAndWrapInArray($values) : array
    {
        if (\is_array($values)) {
            $array = $this->resolveExprFromArray($values);
        } else {
            $expr = $this->resolveExpr($values);
            $items = [new \ConfigTransformer2021082310\PhpParser\Node\Expr\ArrayItem($expr)];
            $array = new \ConfigTransformer2021082310\PhpParser\Node\Expr\Array_($items);
        }
        return [new \ConfigTransformer2021082310\PhpParser\Node\Arg($array)];
    }
    /**
     * @return Arg[]
     */
    public function createFromValues($values, bool $skipServiceReference = \false, bool $skipClassesToConstantReference = \false) : array
    {
        if (\is_array($values)) {
            $args = [];
            foreach ($values as $key => $value) {
                $expr = $this->resolveExpr($value, $skipServiceReference, $skipClassesToConstantReference);
                if (!\is_int($key) && $this->isPhpNamedArguments) {
                    $args[] = new \ConfigTransformer2021082310\PhpParser\Node\Arg(\false, \false, [], new \ConfigTransformer2021082310\PhpParser\Node\Identifier($key));
                } else {
                    $args[] = new \ConfigTransformer2021082310\PhpParser\Node\Arg($expr);
                }
            }
            return $args;
        }
        if ($values instanceof \ConfigTransformer2021082310\PhpParser\Node) {
            if ($values instanceof \ConfigTransformer2021082310\PhpParser\Node\Arg) {
                return [$values];
            }
            if ($values instanceof \ConfigTransformer2021082310\PhpParser\Node\Expr) {
                return [new \ConfigTransformer2021082310\PhpParser\Node\Arg($values)];
            }
        }
        if (\is_string($values)) {
            $expr = $this->resolveExpr($values);
            return [new \ConfigTransformer2021082310\PhpParser\Node\Arg($expr)];
        }
        throw new \ConfigTransformer2021082310\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException();
    }
    public function resolveExpr($value, bool $skipServiceReference = \false, bool $skipClassesToConstantReference = \false) : \ConfigTransformer2021082310\PhpParser\Node\Expr
    {
        if (\is_string($value)) {
            return $this->stringExprResolver->resolve($value, $skipServiceReference, $skipClassesToConstantReference);
        }
        if ($value instanceof \ConfigTransformer2021082310\PhpParser\Node\Expr) {
            return $value;
        }
        if ($value instanceof \ConfigTransformer2021082310\Symfony\Component\Yaml\Tag\TaggedValue) {
            return $this->createServiceReferenceFromTaggedValue($value);
        }
        if (\is_array($value)) {
            $arrayItems = $this->resolveArrayItems($value, $skipClassesToConstantReference);
            return new \ConfigTransformer2021082310\PhpParser\Node\Expr\Array_($arrayItems);
        }
        return \ConfigTransformer2021082310\PhpParser\BuilderHelpers::normalizeValue($value);
    }
    private function resolveExprFromArray(array $values) : \ConfigTransformer2021082310\PhpParser\Node\Expr\Array_
    {
        $arrayItems = [];
        foreach ($values as $key => $value) {
            $expr = \is_array($value) ? $this->resolveExprFromArray($value) : $this->resolveExpr($value);
            if (!\is_int($key)) {
                $keyExpr = $this->resolveExpr($key);
                $arrayItem = new \ConfigTransformer2021082310\PhpParser\Node\Expr\ArrayItem($expr, $keyExpr);
            } else {
                $arrayItem = new \ConfigTransformer2021082310\PhpParser\Node\Expr\ArrayItem($expr);
            }
            $arrayItems[] = $arrayItem;
        }
        return new \ConfigTransformer2021082310\PhpParser\Node\Expr\Array_($arrayItems);
    }
    private function createServiceReferenceFromTaggedValue(\ConfigTransformer2021082310\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \ConfigTransformer2021082310\PhpParser\Node\Expr
    {
        // that's the only value
        if ($taggedValue->getTag() === self::TAG_RETURNS_CLONE) {
            return $this->taggedReturnsCloneResolver->resolve($taggedValue);
        }
        if ($taggedValue->getTag() === self::TAG_SERVICE) {
            return $this->taggedServiceResolver->resolve($taggedValue);
        }
        switch ($taggedValue->getTag()) {
            case 'tagged_iterator':
                $name = new \ConfigTransformer2021082310\PhpParser\Node\Name\FullyQualified(\ConfigTransformer2021082310\Symplify\PhpConfigPrinter\ValueObject\FunctionName::TAGGED_ITERATOR);
                break;
            case 'tagged_locator':
                $name = new \ConfigTransformer2021082310\PhpParser\Node\Name\FullyQualified(\ConfigTransformer2021082310\Symplify\PhpConfigPrinter\ValueObject\FunctionName::TAGGED_LOCATOR);
                break;
            default:
                $name = new \ConfigTransformer2021082310\PhpParser\Node\Name($taggedValue->getTag());
                break;
        }
        $args = $this->createFromValues($taggedValue->getValue());
        return new \ConfigTransformer2021082310\PhpParser\Node\Expr\FuncCall($name, $args);
    }
    /**
     * @param mixed[] $value
     * @return ArrayItem[]
     */
    private function resolveArrayItems(array $value, bool $skipClassesToConstantReference) : array
    {
        $arrayItems = [];
        $naturalKey = 0;
        foreach ($value as $nestedKey => $nestedValue) {
            $valueExpr = $this->resolveExpr($nestedValue, \false, $skipClassesToConstantReference);
            if (!\is_int($nestedKey) || $nestedKey !== $naturalKey) {
                $keyExpr = $this->resolveExpr($nestedKey, \false, $skipClassesToConstantReference);
                $arrayItem = new \ConfigTransformer2021082310\PhpParser\Node\Expr\ArrayItem($valueExpr, $keyExpr);
            } else {
                $arrayItem = new \ConfigTransformer2021082310\PhpParser\Node\Expr\ArrayItem($valueExpr);
            }
            $arrayItems[] = $arrayItem;
            ++$naturalKey;
        }
        return $arrayItems;
    }
}
