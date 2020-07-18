<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Configuration\Configuration;
use Migrify\ConfigTransformer\FormatSwitcher\Exception\NotImplementedYetException;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\SymfonyVersionFeature;
use Nette\Utils\Strings;
use PhpParser\BuilderHelpers;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use Symfony\Component\Yaml\Tag\TaggedValue;

final class ArgsNodeFactory
{
    /**
     * @var string
     */
    private const INLINE_SERVICE = 'inline_service';

    /**
     * @var string
     */
    private const SERVICE = 'service';

    /**
     * @var string
     */
    private const REF = 'ref';

    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;

    /**
     * @var ConstantNodeFactory
     */
    private $constantNodeFactory;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(
        CommonNodeFactory $commonNodeFactory,
        ConstantNodeFactory $constantNodeFactory,
        Configuration $configuration
    ) {
        $this->commonNodeFactory = $commonNodeFactory;
        $this->constantNodeFactory = $constantNodeFactory;
        $this->configuration = $configuration;
    }

    /**
     * @return Arg[]
     */
    public function createFromValuesAndWrapInArray($values): array
    {
        if (is_array($values)) {
            $array = $this->resolveExprFromArray($values);
        } else {
            $expr = $this->resolveExpr($values);
            $items = [new ArrayItem($expr)];
            $array = new Array_($items);
        }

        $arg = new Arg($array);
        return [$arg];
    }

    /**
     * @return Arg[]
     */
    public function createFromValues($values, bool $skipServiceReference = false): array
    {
        if (is_array($values)) {
            $args = [];
            foreach ($values as $value) {
                $expr = $this->resolveExpr($value, $skipServiceReference);
                $args[] = new Arg($expr);
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

        if (is_string($values)) {
            $expr = $this->resolveExpr($values);
            return [new Arg($expr)];
        }

        throw new NotImplementedYetException();
    }

    public function resolveExpr($value, bool $skipServiceReference = false): Expr
    {
        if (is_string($value)) {
            return $this->resolveStringExpr($value, $skipServiceReference);
        }

        if ($value instanceof Expr) {
            return $value;
        }

        if ($value instanceof TaggedValue) {
            return $this->createServiceReferenceFromTaggedValue($value);
        }

        if (is_array($value)) {
            $arrayItems = $this->resolveArrayItems($value);
            return new Array_($arrayItems);
        }

        return BuilderHelpers::normalizeValue($value);
    }

    private function resolveServiceReferenceExpr(
        string $value,
        bool $skipServiceReference,
        string $functionName
    ): Expr {
        $value = ltrim($value, '@');
        $expr = $this->resolveExpr($value);

        if ($skipServiceReference) {
            return $expr;
        }

        $args = [new Arg($expr)];
        return new FuncCall(new Name($functionName), $args);
    }

    private function resolveExprFromArray(array $values): Array_
    {
        $arrayItems = [];
        foreach ($values as $key => $value) {
            $expr = is_array($value) ? $this->resolveExprFromArray($value) : $this->resolveExpr($value);

            if (! is_int($key)) {
                $keyExpr = $this->resolveExpr($key);
                $arrayItem = new ArrayItem($expr, $keyExpr);
            } else {
                $arrayItem = new ArrayItem($expr);
            }

            $arrayItems[] = $arrayItem;
        }

        return new Array_($arrayItems);
    }

    private function createServiceReferenceFromTaggedValue(TaggedValue $taggedValue): Expr
    {
        $shouldWrapInArray = false;

        // that's the only value
        if ($taggedValue->getTag() === 'returns_clone') {
            $serviceName = $taggedValue->getValue()[0];
            $functionName = self::SERVICE;
            $shouldWrapInArray = true;
        } elseif ($taggedValue->getTag() === self::SERVICE) {
            $serviceName = $taggedValue->getValue()['class'];
            $functionName = self::INLINE_SERVICE;
        } else {
            if (is_array($taggedValue->getValue())) {
                $args = $this->createFromValues($taggedValue->getValue());
            } else {
                $args = $this->createFromValues([$taggedValue->getValue()]);
            }

            return new FuncCall(new Name($taggedValue->getTag()), $args);
        }

        $funcCall = $this->resolveServiceReferenceExpr($serviceName, false, $functionName);
        if ($shouldWrapInArray) {
            return new Array_([new ArrayItem($funcCall)]);
        }

        return $funcCall;
    }

    private function resolveStringExpr(string $value, bool $skipServiceReference)
    {
        $value = ltrim($value, '\\');

        if (ctype_upper($value[0]) && class_exists($value) || interface_exists($value)) {
            return $this->commonNodeFactory->createClassReference($value);
        }

        if (Strings::startsWith($value, '@=')) {
            $value = ltrim($value, '@=');
            $args = $this->createFromValues($value);

            return new FuncCall(new Name('expr'), $args);
        }

        // is service reference
        if (Strings::startsWith($value, '@')) {
            if ($this->configuration->isAtLeastSymfonyVersion(SymfonyVersionFeature::REF_OVER_SERVICE)) {
                $functionName = self::SERVICE;
            } else {
                $functionName = self::REF;
            }

            return $this->resolveServiceReferenceExpr($value, $skipServiceReference, $functionName);
        }

        $constantValue = $this->constantNodeFactory->createConstantIfValue($value);
        if ($constantValue !== null) {
            return $constantValue;
        }

        return BuilderHelpers::normalizeValue($value);
    }

    /**
     * @param mixed[] $value
     * @return ArrayItem[]
     */
    private function resolveArrayItems(array $value): array
    {
        $arrayItems = [];

        $naturalKey = 0;
        foreach ($value as $nestedKey => $nestedValue) {
            $valueExpr = $this->resolveExpr($nestedValue);

            if (! is_int($nestedKey) || $nestedKey !== $naturalKey) {
                $keyExpr = $this->resolveExpr($nestedKey);
                $arrayItems[] = new ArrayItem($valueExpr, $keyExpr);
            } else {
                $arrayItems[] = new ArrayItem($valueExpr);
            }

            ++$naturalKey;
        }

        return $arrayItems;
    }
}
