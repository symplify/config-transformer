<?php

declare (strict_types=1);
namespace ConfigTransformer2021090610\PhpParser;

use ConfigTransformer2021090610\PhpParser\Node\Arg;
use ConfigTransformer2021090610\PhpParser\Node\Expr;
use ConfigTransformer2021090610\PhpParser\Node\Expr\BinaryOp\Concat;
use ConfigTransformer2021090610\PhpParser\Node\Identifier;
use ConfigTransformer2021090610\PhpParser\Node\Name;
use ConfigTransformer2021090610\PhpParser\Node\Scalar\String_;
use ConfigTransformer2021090610\PhpParser\Node\Stmt\Use_;
class BuilderFactory
{
    /**
     * Creates an attribute node.
     *
     * @param string|Name $name Name of the attribute
     * @param array       $args Attribute named arguments
     *
     * @return Node\Attribute
     */
    public function attribute($name, $args = []) : \ConfigTransformer2021090610\PhpParser\Node\Attribute
    {
        return new \ConfigTransformer2021090610\PhpParser\Node\Attribute(\ConfigTransformer2021090610\PhpParser\BuilderHelpers::normalizeName($name), $this->args($args));
    }
    /**
     * Creates a namespace builder.
     *
     * @param null|string|Node\Name $name Name of the namespace
     *
     * @return Builder\Namespace_ The created namespace builder
     */
    public function namespace($name) : \ConfigTransformer2021090610\PhpParser\Builder\Namespace_
    {
        return new \ConfigTransformer2021090610\PhpParser\Builder\Namespace_($name);
    }
    /**
     * Creates a class builder.
     *
     * @param string $name Name of the class
     *
     * @return Builder\Class_ The created class builder
     */
    public function class($name) : \ConfigTransformer2021090610\PhpParser\Builder\Class_
    {
        return new \ConfigTransformer2021090610\PhpParser\Builder\Class_($name);
    }
    /**
     * Creates an interface builder.
     *
     * @param string $name Name of the interface
     *
     * @return Builder\Interface_ The created interface builder
     */
    public function interface($name) : \ConfigTransformer2021090610\PhpParser\Builder\Interface_
    {
        return new \ConfigTransformer2021090610\PhpParser\Builder\Interface_($name);
    }
    /**
     * Creates a trait builder.
     *
     * @param string $name Name of the trait
     *
     * @return Builder\Trait_ The created trait builder
     */
    public function trait($name) : \ConfigTransformer2021090610\PhpParser\Builder\Trait_
    {
        return new \ConfigTransformer2021090610\PhpParser\Builder\Trait_($name);
    }
    /**
     * Creates a trait use builder.
     *
     * @param Node\Name|string ...$traits Trait names
     *
     * @return Builder\TraitUse The create trait use builder
     */
    public function useTrait(...$traits) : \ConfigTransformer2021090610\PhpParser\Builder\TraitUse
    {
        return new \ConfigTransformer2021090610\PhpParser\Builder\TraitUse(...$traits);
    }
    /**
     * Creates a trait use adaptation builder.
     *
     * @param Node\Name|string|null  $trait  Trait name
     * @param Node\Identifier|string $method Method name
     *
     * @return Builder\TraitUseAdaptation The create trait use adaptation builder
     */
    public function traitUseAdaptation($trait, $method = null) : \ConfigTransformer2021090610\PhpParser\Builder\TraitUseAdaptation
    {
        if ($method === null) {
            $method = $trait;
            $trait = null;
        }
        return new \ConfigTransformer2021090610\PhpParser\Builder\TraitUseAdaptation($trait, $method);
    }
    /**
     * Creates a method builder.
     *
     * @param string $name Name of the method
     *
     * @return Builder\Method The created method builder
     */
    public function method($name) : \ConfigTransformer2021090610\PhpParser\Builder\Method
    {
        return new \ConfigTransformer2021090610\PhpParser\Builder\Method($name);
    }
    /**
     * Creates a parameter builder.
     *
     * @param string $name Name of the parameter
     *
     * @return Builder\Param The created parameter builder
     */
    public function param($name) : \ConfigTransformer2021090610\PhpParser\Builder\Param
    {
        return new \ConfigTransformer2021090610\PhpParser\Builder\Param($name);
    }
    /**
     * Creates a property builder.
     *
     * @param string $name Name of the property
     *
     * @return Builder\Property The created property builder
     */
    public function property($name) : \ConfigTransformer2021090610\PhpParser\Builder\Property
    {
        return new \ConfigTransformer2021090610\PhpParser\Builder\Property($name);
    }
    /**
     * Creates a function builder.
     *
     * @param string $name Name of the function
     *
     * @return Builder\Function_ The created function builder
     */
    public function function($name) : \ConfigTransformer2021090610\PhpParser\Builder\Function_
    {
        return new \ConfigTransformer2021090610\PhpParser\Builder\Function_($name);
    }
    /**
     * Creates a namespace/class use builder.
     *
     * @param Node\Name|string $name Name of the entity (namespace or class) to alias
     *
     * @return Builder\Use_ The created use builder
     */
    public function use($name) : \ConfigTransformer2021090610\PhpParser\Builder\Use_
    {
        return new \ConfigTransformer2021090610\PhpParser\Builder\Use_($name, \ConfigTransformer2021090610\PhpParser\Node\Stmt\Use_::TYPE_NORMAL);
    }
    /**
     * Creates a function use builder.
     *
     * @param Node\Name|string $name Name of the function to alias
     *
     * @return Builder\Use_ The created use function builder
     */
    public function useFunction($name) : \ConfigTransformer2021090610\PhpParser\Builder\Use_
    {
        return new \ConfigTransformer2021090610\PhpParser\Builder\Use_($name, \ConfigTransformer2021090610\PhpParser\Node\Stmt\Use_::TYPE_FUNCTION);
    }
    /**
     * Creates a constant use builder.
     *
     * @param Node\Name|string $name Name of the const to alias
     *
     * @return Builder\Use_ The created use const builder
     */
    public function useConst($name) : \ConfigTransformer2021090610\PhpParser\Builder\Use_
    {
        return new \ConfigTransformer2021090610\PhpParser\Builder\Use_($name, \ConfigTransformer2021090610\PhpParser\Node\Stmt\Use_::TYPE_CONSTANT);
    }
    /**
     * Creates a class constant builder.
     *
     * @param string|Identifier                          $name  Name
     * @param Node\Expr|bool|null|int|float|string|array $value Value
     *
     * @return Builder\ClassConst The created use const builder
     */
    public function classConst($name, $value) : \ConfigTransformer2021090610\PhpParser\Builder\ClassConst
    {
        return new \ConfigTransformer2021090610\PhpParser\Builder\ClassConst($name, $value);
    }
    /**
     * Creates node a for a literal value.
     *
     * @param Expr|bool|null|int|float|string|array $value $value
     *
     * @return Expr
     */
    public function val($value) : \ConfigTransformer2021090610\PhpParser\Node\Expr
    {
        return \ConfigTransformer2021090610\PhpParser\BuilderHelpers::normalizeValue($value);
    }
    /**
     * Creates variable node.
     *
     * @param string|Expr $name Name
     *
     * @return Expr\Variable
     */
    public function var($name) : \ConfigTransformer2021090610\PhpParser\Node\Expr\Variable
    {
        if (!\is_string($name) && !$name instanceof \ConfigTransformer2021090610\PhpParser\Node\Expr) {
            throw new \LogicException('Variable name must be string or Expr');
        }
        return new \ConfigTransformer2021090610\PhpParser\Node\Expr\Variable($name);
    }
    /**
     * Normalizes an argument list.
     *
     * Creates Arg nodes for all arguments and converts literal values to expressions.
     *
     * @param array $args List of arguments to normalize
     *
     * @return Arg[]
     */
    public function args($args) : array
    {
        $normalizedArgs = [];
        foreach ($args as $key => $arg) {
            if (!$arg instanceof \ConfigTransformer2021090610\PhpParser\Node\Arg) {
                $arg = new \ConfigTransformer2021090610\PhpParser\Node\Arg(\ConfigTransformer2021090610\PhpParser\BuilderHelpers::normalizeValue($arg));
            }
            if (\is_string($key)) {
                $arg->name = \ConfigTransformer2021090610\PhpParser\BuilderHelpers::normalizeIdentifier($key);
            }
            $normalizedArgs[] = $arg;
        }
        return $normalizedArgs;
    }
    /**
     * Creates a function call node.
     *
     * @param string|Name|Expr $name Function name
     * @param array            $args Function arguments
     *
     * @return Expr\FuncCall
     */
    public function funcCall($name, $args = []) : \ConfigTransformer2021090610\PhpParser\Node\Expr\FuncCall
    {
        return new \ConfigTransformer2021090610\PhpParser\Node\Expr\FuncCall(\ConfigTransformer2021090610\PhpParser\BuilderHelpers::normalizeNameOrExpr($name), $this->args($args));
    }
    /**
     * Creates a method call node.
     *
     * @param Expr                   $var  Variable the method is called on
     * @param string|Identifier|Expr $name Method name
     * @param array                  $args Method arguments
     *
     * @return Expr\MethodCall
     */
    public function methodCall($var, $name, $args = []) : \ConfigTransformer2021090610\PhpParser\Node\Expr\MethodCall
    {
        return new \ConfigTransformer2021090610\PhpParser\Node\Expr\MethodCall($var, \ConfigTransformer2021090610\PhpParser\BuilderHelpers::normalizeIdentifierOrExpr($name), $this->args($args));
    }
    /**
     * Creates a static method call node.
     *
     * @param string|Name|Expr       $class Class name
     * @param string|Identifier|Expr $name  Method name
     * @param array                  $args  Method arguments
     *
     * @return Expr\StaticCall
     */
    public function staticCall($class, $name, $args = []) : \ConfigTransformer2021090610\PhpParser\Node\Expr\StaticCall
    {
        return new \ConfigTransformer2021090610\PhpParser\Node\Expr\StaticCall(\ConfigTransformer2021090610\PhpParser\BuilderHelpers::normalizeNameOrExpr($class), \ConfigTransformer2021090610\PhpParser\BuilderHelpers::normalizeIdentifierOrExpr($name), $this->args($args));
    }
    /**
     * Creates an object creation node.
     *
     * @param string|Name|Expr $class Class name
     * @param array            $args  Constructor arguments
     *
     * @return Expr\New_
     */
    public function new($class, $args = []) : \ConfigTransformer2021090610\PhpParser\Node\Expr\New_
    {
        return new \ConfigTransformer2021090610\PhpParser\Node\Expr\New_(\ConfigTransformer2021090610\PhpParser\BuilderHelpers::normalizeNameOrExpr($class), $this->args($args));
    }
    /**
     * Creates a constant fetch node.
     *
     * @param string|Name $name Constant name
     *
     * @return Expr\ConstFetch
     */
    public function constFetch($name) : \ConfigTransformer2021090610\PhpParser\Node\Expr\ConstFetch
    {
        return new \ConfigTransformer2021090610\PhpParser\Node\Expr\ConstFetch(\ConfigTransformer2021090610\PhpParser\BuilderHelpers::normalizeName($name));
    }
    /**
     * Creates a property fetch node.
     *
     * @param Expr                   $var  Variable holding object
     * @param string|Identifier|Expr $name Property name
     *
     * @return Expr\PropertyFetch
     */
    public function propertyFetch($var, $name) : \ConfigTransformer2021090610\PhpParser\Node\Expr\PropertyFetch
    {
        return new \ConfigTransformer2021090610\PhpParser\Node\Expr\PropertyFetch($var, \ConfigTransformer2021090610\PhpParser\BuilderHelpers::normalizeIdentifierOrExpr($name));
    }
    /**
     * Creates a class constant fetch node.
     *
     * @param string|Name|Expr  $class Class name
     * @param string|Identifier $name  Constant name
     *
     * @return Expr\ClassConstFetch
     */
    public function classConstFetch($class, $name) : \ConfigTransformer2021090610\PhpParser\Node\Expr\ClassConstFetch
    {
        return new \ConfigTransformer2021090610\PhpParser\Node\Expr\ClassConstFetch(\ConfigTransformer2021090610\PhpParser\BuilderHelpers::normalizeNameOrExpr($class), \ConfigTransformer2021090610\PhpParser\BuilderHelpers::normalizeIdentifier($name));
    }
    /**
     * Creates nested Concat nodes from a list of expressions.
     *
     * @param Expr|string ...$exprs Expressions or literal strings
     *
     * @return Concat
     */
    public function concat(...$exprs) : \ConfigTransformer2021090610\PhpParser\Node\Expr\BinaryOp\Concat
    {
        $numExprs = \count($exprs);
        if ($numExprs < 2) {
            throw new \LogicException('Expected at least two expressions');
        }
        $lastConcat = $this->normalizeStringExpr($exprs[0]);
        for ($i = 1; $i < $numExprs; $i++) {
            $lastConcat = new \ConfigTransformer2021090610\PhpParser\Node\Expr\BinaryOp\Concat($lastConcat, $this->normalizeStringExpr($exprs[$i]));
        }
        return $lastConcat;
    }
    /**
     * @param string|Expr $expr
     * @return Expr
     */
    private function normalizeStringExpr($expr) : \ConfigTransformer2021090610\PhpParser\Node\Expr
    {
        if ($expr instanceof \ConfigTransformer2021090610\PhpParser\Node\Expr) {
            return $expr;
        }
        if (\is_string($expr)) {
            return new \ConfigTransformer2021090610\PhpParser\Node\Scalar\String_($expr);
        }
        throw new \LogicException('Expected string or Expr');
    }
}
