<?php

declare (strict_types=1);
namespace ConfigTransformer202205150\Symplify\Astral\PhpDocParser\ValueObject\Ast\PhpDoc;

use ConfigTransformer202205150\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode;
use ConfigTransformer202205150\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use ConfigTransformer202205150\PHPStan\PhpDocParser\Ast\Type\TypeNode;
/**
 * @noRector final on purpose, so it can be extended by 3rd party
 */
class SimplePhpDocNode extends \ConfigTransformer202205150\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode
{
    public function getParam(string $desiredParamName) : ?\ConfigTransformer202205150\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode
    {
        $desiredParamNameWithDollar = '$' . \ltrim($desiredParamName, '$');
        foreach ($this->getParamTagValues() as $paramTagValueNode) {
            if ($paramTagValueNode->parameterName !== $desiredParamNameWithDollar) {
                continue;
            }
            return $paramTagValueNode;
        }
        return null;
    }
    public function getParamType(string $desiredParamName) : ?\ConfigTransformer202205150\PHPStan\PhpDocParser\Ast\Type\TypeNode
    {
        $paramTagValueNode = $this->getParam($desiredParamName);
        if (!$paramTagValueNode instanceof \ConfigTransformer202205150\PHPStan\PhpDocParser\Ast\PhpDoc\ParamTagValueNode) {
            return null;
        }
        return $paramTagValueNode->type;
    }
}
