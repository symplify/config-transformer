<?php

declare (strict_types=1);
namespace ConfigTransformer2022031610\Symplify\Astral\StaticFactory;

use ConfigTransformer2022031610\PhpParser\NodeFinder;
use ConfigTransformer2022031610\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer2022031610\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer2022031610\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @api
 */
final class NodeValueResolverStaticFactory
{
    public static function create() : \ConfigTransformer2022031610\Symplify\Astral\NodeValue\NodeValueResolver
    {
        $simpleNameResolver = \ConfigTransformer2022031610\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::create();
        $simpleNodeFinder = new \ConfigTransformer2022031610\Symplify\Astral\NodeFinder\SimpleNodeFinder(new \ConfigTransformer2022031610\PhpParser\NodeFinder());
        return new \ConfigTransformer2022031610\Symplify\Astral\NodeValue\NodeValueResolver($simpleNameResolver, new \ConfigTransformer2022031610\Symplify\PackageBuilder\Php\TypeChecker(), $simpleNodeFinder);
    }
}
