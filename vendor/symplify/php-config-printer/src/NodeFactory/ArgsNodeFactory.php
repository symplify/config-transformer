<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\NodeFactory;

use ConfigTransformerPrefix202501\PhpParser\BuilderHelpers;
use ConfigTransformerPrefix202501\PhpParser\Node;
use ConfigTransformerPrefix202501\PhpParser\Node\Arg;
use ConfigTransformerPrefix202501\PhpParser\Node\ArrayItem;
use ConfigTransformerPrefix202501\PhpParser\Node\Expr;
use ConfigTransformerPrefix202501\PhpParser\Node\Expr\Array_;
use ConfigTransformerPrefix202501\PhpParser\Node\Expr\FuncCall;
use ConfigTransformerPrefix202501\PhpParser\Node\Identifier;
use ConfigTransformerPrefix202501\PhpParser\Node\Name;
use ConfigTransformerPrefix202501\PhpParser\Node\Name\FullyQualified;
use ConfigTransformerPrefix202501\Symfony\Component\Yaml\Tag\TaggedValue;
use Symplify\PhpConfigPrinter\Exception\NotImplementedYetException;
use Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver;
use Symplify\PhpConfigPrinter\ExprResolver\TaggedReturnsCloneResolver;
use Symplify\PhpConfigPrinter\ExprResolver\TaggedServiceResolver;
use Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class ArgsNodeFactory
{
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\ExprResolver\StringExprResolver
     */
    private $stringExprResolver;
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\ExprResolver\TaggedReturnsCloneResolver
     */
    private $taggedReturnsCloneResolver;
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\ExprResolver\TaggedServiceResolver
     */
    private $taggedServiceResolver;
    /**
     * @readonly
     * @var \Symplify\PhpConfigPrinter\NodeFactory\NewValueObjectFactory
     */
    private $newValueObjectFactory;
    /**
     * @var string
     */
    private const TAG_SERVICE = 'service';
    /**
     * @var string
     */
    private const TAG_RETURNS_CLONE = 'returns_clone';
    /**
     * @readonly
     * @var bool
     */
    private $isPhpNamedArguments;
    public function __construct(StringExprResolver $stringExprResolver, TaggedReturnsCloneResolver $taggedReturnsCloneResolver, TaggedServiceResolver $taggedServiceResolver, \Symplify\PhpConfigPrinter\NodeFactory\NewValueObjectFactory $newValueObjectFactory)
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
            $items = [new ArrayItem($expr)];
            $array = new Array_($items);
        }
        return [new Arg($array)];
    }
    /**
     * @return mixed[]|Arg[]
     * @param mixed $values
     */
    public function createFromValues($values, bool $skipServiceReference = \false, bool $skipClassesToConstantReference = \false, bool $isForConfig = \false, bool $isRoutingImport = \false) : array
    {
        if (\is_array($values)) {
            $args = [];
            foreach ($values as $key => $value) {
                $expr = $this->resolveExpr($value, $skipServiceReference, $skipClassesToConstantReference, $isRoutingImport);
                $args = $this->resolveArgs($args, $key, $expr, $isForConfig);
            }
            return $args;
        }
        if ($values instanceof Node) {
            if ($values instanceof Arg) {
                return [$values];
            }
            if ($values instanceof Expr) {
                return [new Arg($values)];
            }
        }
        if (\is_string($values)) {
            $expr = $this->resolveExpr($values);
            return [new Arg($expr)];
        }
        throw new NotImplementedYetException();
    }
    /**
     * @param mixed $value
     */
    public function resolveExpr($value, bool $skipServiceReference = \false, bool $skipClassesToConstantReference = \false, bool $isRoutingImport = \false) : Expr
    {
        if (\is_string($value)) {
            return $this->stringExprResolver->resolve($value, $skipServiceReference, $skipClassesToConstantReference, $isRoutingImport);
        }
        if ($value instanceof Expr) {
            return $value;
        }
        if ($value instanceof TaggedValue) {
            return $this->createServiceReferenceFromTaggedValue($value);
        }
        if (\is_array($value)) {
            $arrayItems = $this->resolveArrayItems($value, $skipClassesToConstantReference);
            return new Array_($arrayItems);
        }
        if (\is_object($value)) {
            return $this->newValueObjectFactory->create($value);
        }
        return BuilderHelpers::normalizeValue($value);
    }
    /**
     * @param mixed[] $values
     */
    public function resolveExprFromArray(array $values) : Array_
    {
        $arrayItems = [];
        $hasNaturalKeysOrder = $this->hasNaturalKeyOrder($values);
        foreach ($values as $key => $value) {
            $expr = \is_array($value) ? $this->resolveExprFromArray($value) : $this->resolveExpr($value);
            if (!\is_int($key) || !$hasNaturalKeysOrder) {
                $keyExpr = $this->resolveExpr($key);
                $arrayItem = new ArrayItem($expr, $keyExpr);
            } else {
                $arrayItem = new ArrayItem($expr);
            }
            $arrayItems[] = $arrayItem;
        }
        return new Array_($arrayItems);
    }
    /**
     * @param Arg[] $args
     * @return Arg[]
     * @param mixed $key
     */
    private function resolveArgs(array $args, $key, Expr $expr, bool $isForConfig) : array
    {
        if (\is_string($key) && $isForConfig) {
            $key = $this->resolveExpr($key);
            $args[] = new Arg(new Array_([new ArrayItem($expr, $key)]));
            return $args;
        }
        if (!\is_int($key) && $this->isPhpNamedArguments) {
            $args[] = new Arg($expr, \false, \false, [], new Identifier($key));
            return $args;
        }
        $args[] = new Arg($expr);
        return $args;
    }
    private function createServiceReferenceFromTaggedValue(TaggedValue $taggedValue) : Expr
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
                $name = new FullyQualified(FunctionName::TAGGED_ITERATOR);
                break;
            case 'tagged_locator':
                $name = new FullyQualified(FunctionName::TAGGED_LOCATOR);
                break;
            default:
                $name = new Name($taggedValue->getTag());
                break;
        }
        $args = $this->createFromValues($taggedValue->getValue());
        return new FuncCall($name, $args);
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
                $arrayItem = new ArrayItem($valueExpr, $keyExpr);
            } else {
                $arrayItem = new ArrayItem($valueExpr);
            }
            $arrayItems[] = $arrayItem;
            ++$naturalKey;
        }
        return $arrayItems;
    }
    /**
     * Detects, if the array keys are implicit - natural order integers: 0, 1, 2, 3...
     *
     * @param array<mixed, mixed> $values
     */
    private function hasNaturalKeyOrder(array $values) : bool
    {
        $valueCount = \count($values);
        $naturalOrderKeys = \range(0, $valueCount - 1);
        return $naturalOrderKeys === \array_keys($values);
    }
}
