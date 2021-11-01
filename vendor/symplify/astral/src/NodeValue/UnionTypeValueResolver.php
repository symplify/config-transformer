<?php

declare (strict_types=1);
namespace ConfigTransformer2021110110\Symplify\Astral\NodeValue;

use ConfigTransformer2021110110\PHPStan\Type\ConstantScalarType;
use ConfigTransformer2021110110\PHPStan\Type\UnionType;
final class UnionTypeValueResolver
{
    /**
     * @return mixed[]
     */
    public function resolveConstantTypes(\ConfigTransformer2021110110\PHPStan\Type\UnionType $unionType) : array
    {
        $resolvedValues = [];
        foreach ($unionType->getTypes() as $unionedType) {
            if (!$unionedType instanceof \ConfigTransformer2021110110\PHPStan\Type\ConstantScalarType) {
                continue;
            }
            $resolvedValues[] = $unionedType->getValue();
        }
        return $resolvedValues;
    }
}
