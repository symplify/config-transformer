<?php

declare (strict_types=1);
namespace ConfigTransformer2021110310\Symplify\Astral\TypeAnalyzer;

use ConfigTransformer2021110310\PhpParser\Node\Expr;
use ConfigTransformer2021110310\PHPStan\Analyser\Scope;
use ConfigTransformer2021110310\PHPStan\Type\ArrayType;
use ConfigTransformer2021110310\PHPStan\Type\IntersectionType;
use ConfigTransformer2021110310\PHPStan\Type\Type;
use ConfigTransformer2021110310\PHPStan\Type\TypeWithClassName;
use ConfigTransformer2021110310\PHPStan\Type\UnionType;
final class ContainsTypeAnalyser
{
    /**
     * @param class-string[] $types
     */
    public function containsExprTypes(\ConfigTransformer2021110310\PhpParser\Node\Expr $expr, \ConfigTransformer2021110310\PHPStan\Analyser\Scope $scope, array $types) : bool
    {
        foreach ($types as $type) {
            if (!$this->containsExprType($expr, $scope, $type)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    /**
     * @param class-string[] $types
     */
    public function containsTypeExprTypes(\ConfigTransformer2021110310\PHPStan\Type\Type $exprType, array $types) : bool
    {
        foreach ($types as $type) {
            if ($this->containsTypeExprType($exprType, $type)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param class-string $type
     */
    public function containsTypeExprType(\ConfigTransformer2021110310\PHPStan\Type\Type $exprType, string $type) : bool
    {
        if ($exprType instanceof \ConfigTransformer2021110310\PHPStan\Type\IntersectionType) {
            $intersectionedTypes = $exprType->getTypes();
            foreach ($intersectionedTypes as $intersectionedType) {
                if ($this->isExprTypeOfType($intersectionedType, $type)) {
                    return \true;
                }
            }
        }
        return $this->isExprTypeOfType($exprType, $type);
    }
    /**
     * @param class-string $type
     */
    public function containsExprType(\ConfigTransformer2021110310\PhpParser\Node\Expr $expr, \ConfigTransformer2021110310\PHPStan\Analyser\Scope $scope, string $type) : bool
    {
        $exprType = $scope->getType($expr);
        return $this->containsTypeExprType($exprType, $type);
    }
    /**
     * @param class-string $class
     */
    private function isUnionTypeWithClass(\ConfigTransformer2021110310\PHPStan\Type\Type $type, string $class) : bool
    {
        if (!$type instanceof \ConfigTransformer2021110310\PHPStan\Type\UnionType) {
            return \false;
        }
        $unionedTypes = $type->getTypes();
        foreach ($unionedTypes as $unionedType) {
            if (!$unionedType instanceof \ConfigTransformer2021110310\PHPStan\Type\TypeWithClassName) {
                continue;
            }
            if (\is_a($unionedType->getClassName(), $class, \true)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param class-string $type
     */
    private function isArrayWithItemType(\ConfigTransformer2021110310\PHPStan\Type\Type $propertyType, string $type) : bool
    {
        if (!$propertyType instanceof \ConfigTransformer2021110310\PHPStan\Type\ArrayType) {
            return \false;
        }
        $arrayItemType = $propertyType->getItemType();
        if (!$arrayItemType instanceof \ConfigTransformer2021110310\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        return \is_a($arrayItemType->getClassName(), $type, \true);
    }
    /**
     * @param class-string $type
     */
    private function isExprTypeOfType(\ConfigTransformer2021110310\PHPStan\Type\Type $exprType, string $type) : bool
    {
        if ($exprType instanceof \ConfigTransformer2021110310\PHPStan\Type\TypeWithClassName) {
            return \is_a($exprType->getClassName(), $type, \true);
        }
        if ($this->isUnionTypeWithClass($exprType, $type)) {
            return \true;
        }
        return $this->isArrayWithItemType($exprType, $type);
    }
}
