<?php

declare (strict_types=1);
namespace ConfigTransformer202208\Symplify\Astral\StaticFactory;

use ConfigTransformer202208\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202208\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @api
 */
final class NodeValueResolverStaticFactory
{
    public static function create() : NodeValueResolver
    {
        return new NodeValueResolver(new TypeChecker());
    }
}
