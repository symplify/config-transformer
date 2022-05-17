<?php

declare (strict_types=1);
namespace ConfigTransformer2022051710\Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformer2022051710\PhpParser\BuilderHelpers;
use ConfigTransformer2022051710\PhpParser\Node;
use ConfigTransformer2022051710\PhpParser\Node\Arg;
use ConfigTransformer2022051710\PhpParser\Node\Expr;
use ConfigTransformer2022051710\PhpParser\Node\Expr\Array_;
use ConfigTransformer2022051710\PhpParser\Node\Expr\ArrayItem;
use ConfigTransformer2022051710\PhpParser\Node\Expr\FuncCall;
use ConfigTransformer2022051710\PhpParser\Node\Identifier;
use ConfigTransformer2022051710\PhpParser\Node\Name;
use ConfigTransformer2022051710\PhpParser\Node\Name\FullyQualified;
use ConfigTransformer2022051710\Symfony\Component\Yaml\Tag\TaggedValue;
use ConfigTransformer2022051710\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException;
use ConfigTransformer2022051710\Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver;
use ConfigTransformer2022051710\Symplify\PhpConfigPrinter\ExprResolver\TaggedReturnsCloneResolver;
use ConfigTransformer2022051710\Symplify\PhpConfigPrinter\ExprResolver\TaggedServiceResolver;
use ConfigTransformer2022051710\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
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
    /**
     * @var \Symplify\PhpConfigPrinter\NodeFactory\NewValueObjectFactory
     */
    private $newValueObjectFactory;
    public function __construct(\ConfigTransformer2022051710\Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver $stringExprResolver, \ConfigTransformer2022051710\Symplify\PhpConfigPrinter\ExprResolver\TaggedReturnsCloneResolver $taggedReturnsCloneResolver, \ConfigTransformer2022051710\Symplify\PhpConfigPrinter\ExprResolver\TaggedServiceResolver $taggedServiceResolver, \ConfigTransformer2022051710\Symplify\PhpConfigPrinter\NodeFactory\NewValueObjectFactory $newValueObjectFactory)
    {
        $this->stringExprResolver = $stringExprResolver;
        $this->taggedReturnsCloneResolver = $taggedReturnsCloneResolver;
        $this->taggedServiceResolver = $taggedServiceResolver;
        $this->newValueObjectFactory = $newValueObjectFactory;
        $this->isPhpNamedArguments = \PHP_VERSION_ID >= 80000;
    }
    /**
     * @return Arg[]
     * @param mixed $values
     */
    public function createFromValuesAndWrapInArray($values) : array
    {
        if (\is_array($values)) {
            $array = $this->resolveExprFromArray($values);
        } else {
            $expr = $this->resolveExpr($values);
            $items = [new \ConfigTransformer2022051710\PhpParser\Node\Expr\ArrayItem($expr)];
            $array = new \ConfigTransformer2022051710\PhpParser\Node\Expr\Array_($items);
        }
        return [new \ConfigTransformer2022051710\PhpParser\Node\Arg($array)];
    }
    /**
     * @param Arg[] $args
     * @return Arg[]
     * @param mixed $key
     */
    private function resolveArgs(array $args, $key, \ConfigTransformer2022051710\PhpParser\Node\Expr $expr, bool $isForConfig) : array
    {
        if (\is_string($key) && $isForConfig) {
            $key = $this->resolveExpr($key);
            $args[] = new \ConfigTransformer2022051710\PhpParser\Node\Arg(new \ConfigTransformer2022051710\PhpParser\Node\Expr\ArrayItem($expr, $key));
            return $args;
        }
        if (!\is_int($key) && $this->isPhpNamedArguments) {
            $args[] = new \ConfigTransformer2022051710\PhpParser\Node\Arg($expr, \false, \false, [], new \ConfigTransformer2022051710\PhpParser\Node\Identifier($key));
            return $args;
        }
        $args[] = new \ConfigTransformer2022051710\PhpParser\Node\Arg($expr);
        return $args;
    }
    /**
     * @return mixed[]|Arg[]
     * @param mixed $values
     */
    public function createFromValues($values, bool $skipServiceReference = \false, bool $skipClassesToConstantReference = \false, bool $isForConfig = \false) : array
    {
        if (\is_array($values)) {
            $args = [];
            foreach ($values as $key => $value) {
                $expr = $this->resolveExpr($value, $skipServiceReference, $skipClassesToConstantReference);
                $args = $this->resolveArgs($args, $key, $expr, $isForConfig);
            }
            return $args;
        }
        if ($values instanceof \ConfigTransformer2022051710\PhpParser\Node) {
            if ($values instanceof \ConfigTransformer2022051710\PhpParser\Node\Arg) {
                return [$values];
            }
            if ($values instanceof \ConfigTransformer2022051710\PhpParser\Node\Expr) {
                return [new \ConfigTransformer2022051710\PhpParser\Node\Arg($values)];
            }
        }
        if (\is_string($values)) {
            $expr = $this->resolveExpr($values);
            return [new \ConfigTransformer2022051710\PhpParser\Node\Arg($expr)];
        }
        throw new \ConfigTransformer2022051710\Symplify\PhpConfigPrinter\Exception\NotImplementedYetException();
    }
    /**
     * @param mixed $value
     */
    public function resolveExpr($value, bool $skipServiceReference = \false, bool $skipClassesToConstantReference = \false) : \ConfigTransformer2022051710\PhpParser\Node\Expr
    {
        if (\is_string($value)) {
            return $this->stringExprResolver->resolve($value, $skipServiceReference, $skipClassesToConstantReference);
        }
        if ($value instanceof \ConfigTransformer2022051710\PhpParser\Node\Expr) {
            return $value;
        }
        if ($value instanceof \ConfigTransformer2022051710\Symfony\Component\Yaml\Tag\TaggedValue) {
            return $this->createServiceReferenceFromTaggedValue($value);
        }
        if (\is_array($value)) {
            $arrayItems = $this->resolveArrayItems($value, $skipClassesToConstantReference);
            return new \ConfigTransformer2022051710\PhpParser\Node\Expr\Array_($arrayItems);
        }
        if (\is_object($value)) {
            return $this->newValueObjectFactory->create($value);
        }
        return \ConfigTransformer2022051710\PhpParser\BuilderHelpers::normalizeValue($value);
    }
    /**
     * @param mixed[] $values
     */
    public function resolveExprFromArray(array $values) : \ConfigTransformer2022051710\PhpParser\Node\Expr\Array_
    {
        $arrayItems = [];
        foreach ($values as $key => $value) {
            $expr = \is_array($value) ? $this->resolveExprFromArray($value) : $this->resolveExpr($value);
            if (!\is_int($key)) {
                $keyExpr = $this->resolveExpr($key);
                $arrayItem = new \ConfigTransformer2022051710\PhpParser\Node\Expr\ArrayItem($expr, $keyExpr);
            } else {
                $arrayItem = new \ConfigTransformer2022051710\PhpParser\Node\Expr\ArrayItem($expr);
            }
            $arrayItems[] = $arrayItem;
        }
        return new \ConfigTransformer2022051710\PhpParser\Node\Expr\Array_($arrayItems);
    }
    private function createServiceReferenceFromTaggedValue(\ConfigTransformer2022051710\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \ConfigTransformer2022051710\PhpParser\Node\Expr
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
                $name = new \ConfigTransformer2022051710\PhpParser\Node\Name\FullyQualified(\ConfigTransformer2022051710\Symplify\PhpConfigPrinter\ValueObject\FunctionName::TAGGED_ITERATOR);
                break;
            case 'tagged_locator':
                $name = new \ConfigTransformer2022051710\PhpParser\Node\Name\FullyQualified(\ConfigTransformer2022051710\Symplify\PhpConfigPrinter\ValueObject\FunctionName::TAGGED_LOCATOR);
                break;
            default:
                $name = new \ConfigTransformer2022051710\PhpParser\Node\Name($taggedValue->getTag());
                break;
        }
        $args = $this->createFromValues($taggedValue->getValue());
        return new \ConfigTransformer2022051710\PhpParser\Node\Expr\FuncCall($name, $args);
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
                $arrayItem = new \ConfigTransformer2022051710\PhpParser\Node\Expr\ArrayItem($valueExpr, $keyExpr);
            } else {
                $arrayItem = new \ConfigTransformer2022051710\PhpParser\Node\Expr\ArrayItem($valueExpr);
            }
            $arrayItems[] = $arrayItem;
            ++$naturalKey;
        }
        return $arrayItems;
    }
}
