<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\PhpParser\NodeFactory;

use Migrify\ConfigTransformer\FormatSwitcher\Exception\NotImplementedYetException;
use Migrify\ConfigTransformer\Naming\ClassNaming;
use Nette\Utils\Strings;
use PhpParser\BuilderHelpers;
use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;

final class ArgsNodeFactory
{
    /**
     * @var ClassNaming
     */
    private $classNaming;

    public function __construct(ClassNaming $classNaming)
    {
        $this->classNaming = $classNaming;
    }

    /**
     * @return Arg[]
     */
    public function createFromValuesAndWrapInArray($values): array
    {
        $items = [];
        foreach ($values as $value) {
            $expr = $this->resolveExpr($value);
            $items[] = new ArrayItem($expr);
        }

        $array = new Array_($items);
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

        throw new NotImplementedYetException();
    }

    private function resolveExpr($value, bool $skipServiceReference = false): Expr
    {
        if (is_string($value)) {
            if (class_exists($value) || interface_exists($value)) {
                $shortClassName = $this->classNaming->getShortName($value);
                return new ClassConstFetch(new Name($shortClassName), 'class');
            }

            if (Strings::startsWith($value, '@=')) {
                $value = ltrim($value, '@=');
                $expr = $this->resolveExpr($value);
                $args = [new Arg($expr)];
                return new FuncCall(new Name('expr'), $args);
            }

            // is service reference
            if (Strings::startsWith($value, '@')) {
                return $this->resolveServiceReferenceExpr($value, $skipServiceReference);
            }

            if (Strings::contains($value, '::')) {
                [$class, $constant] = explode('::', $value);
                return new ClassConstFetch(new Name($class), $constant);
            }
        }

        return BuilderHelpers::normalizeValue($value);
    }

    private function resolveServiceReferenceExpr(string $value, bool $skipServiceReference): Expr
    {
        $value = ltrim($value, '@');
        $expr = $this->resolveExpr($value);

        if ($skipServiceReference) {
            return $expr;
        }

        $args = [new Arg($expr)];
        return new FuncCall(new Name('service'), $args);
    }
}
