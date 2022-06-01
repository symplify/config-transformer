<?php

declare (strict_types=1);
namespace ConfigTransformer202206019\Symplify\Astral\NodeValue;

use ConfigTransformer202206019\PHPStan\Type\ConstantScalarType;
use ConfigTransformer202206019\PHPStan\Type\UnionType;
final class UnionTypeValueResolver
{
    /**
     * @return mixed[]
     */
    public function resolveConstantTypes(\ConfigTransformer202206019\PHPStan\Type\UnionType $unionType) : array
    {
        $resolvedValues = [];
        foreach ($unionType->getTypes() as $unionedType) {
            if (!$unionedType instanceof \ConfigTransformer202206019\PHPStan\Type\ConstantScalarType) {
                continue;
            }
            $resolvedValues[] = $unionedType->getValue();
        }
        return $resolvedValues;
    }
}
