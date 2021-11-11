<?php

declare (strict_types=1);
namespace ConfigTransformer202111117\Symplify\Astral\TypeAnalyzer;

use ConfigTransformer202111117\PhpParser\Node\Expr;
use ConfigTransformer202111117\PHPStan\Analyser\Scope;
use ConfigTransformer202111117\PHPStan\Type\ArrayType;
use ConfigTransformer202111117\PHPStan\Type\IntersectionType;
use ConfigTransformer202111117\PHPStan\Type\Type;
use ConfigTransformer202111117\PHPStan\Type\TypeWithClassName;
use ConfigTransformer202111117\PHPStan\Type\UnionType;
final class ContainsTypeAnalyser
{
    /**
     * @param class-string[] $types
     */
    public function containsExprTypes(\ConfigTransformer202111117\PhpParser\Node\Expr $expr, \ConfigTransformer202111117\PHPStan\Analyser\Scope $scope, array $types) : bool
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
    public function containsTypeExprTypes(\ConfigTransformer202111117\PHPStan\Type\Type $exprType, array $types) : bool
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
    public function containsTypeExprType(\ConfigTransformer202111117\PHPStan\Type\Type $exprType, string $type) : bool
    {
        if ($exprType instanceof \ConfigTransformer202111117\PHPStan\Type\IntersectionType) {
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
    public function containsExprType(\ConfigTransformer202111117\PhpParser\Node\Expr $expr, \ConfigTransformer202111117\PHPStan\Analyser\Scope $scope, string $type) : bool
    {
        $exprType = $scope->getType($expr);
        return $this->containsTypeExprType($exprType, $type);
    }
    /**
     * @param class-string $class
     */
    private function isUnionTypeWithClass(\ConfigTransformer202111117\PHPStan\Type\Type $type, string $class) : bool
    {
        if (!$type instanceof \ConfigTransformer202111117\PHPStan\Type\UnionType) {
            return \false;
        }
        $unionedTypes = $type->getTypes();
        foreach ($unionedTypes as $unionedType) {
            if (!$unionedType instanceof \ConfigTransformer202111117\PHPStan\Type\TypeWithClassName) {
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
    private function isArrayWithItemType(\ConfigTransformer202111117\PHPStan\Type\Type $propertyType, string $type) : bool
    {
        if (!$propertyType instanceof \ConfigTransformer202111117\PHPStan\Type\ArrayType) {
            return \false;
        }
        $arrayItemType = $propertyType->getItemType();
        if (!$arrayItemType instanceof \ConfigTransformer202111117\PHPStan\Type\TypeWithClassName) {
            return \false;
        }
        return \is_a($arrayItemType->getClassName(), $type, \true);
    }
    /**
     * @param class-string $type
     */
    private function isExprTypeOfType(\ConfigTransformer202111117\PHPStan\Type\Type $exprType, string $type) : bool
    {
        if ($exprType instanceof \ConfigTransformer202111117\PHPStan\Type\TypeWithClassName) {
            return \is_a($exprType->getClassName(), $type, \true);
        }
        if ($this->isUnionTypeWithClass($exprType, $type)) {
            return \true;
        }
        return $this->isArrayWithItemType($exprType, $type);
    }
}
