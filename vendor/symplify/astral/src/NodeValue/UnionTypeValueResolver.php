<?php

declare (strict_types=1);
namespace ConfigTransformer202206079\Symplify\Astral\NodeValue;

use ConfigTransformer202206079\PHPStan\Type\ConstantScalarType;
use ConfigTransformer202206079\PHPStan\Type\UnionType;
final class UnionTypeValueResolver
{
    /**
     * @return mixed[]
     */
    public function resolveConstantTypes(UnionType $unionType) : array
    {
        $resolvedValues = [];
        foreach ($unionType->getTypes() as $unionedType) {
            if (!$unionedType instanceof ConstantScalarType) {
                continue;
            }
            $resolvedValues[] = $unionedType->getValue();
        }
        return $resolvedValues;
    }
}
