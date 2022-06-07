<?php

declare (strict_types=1);
namespace ConfigTransformer202206072\Symplify\Astral\StaticFactory;

use ConfigTransformer202206072\PhpParser\NodeFinder;
use ConfigTransformer202206072\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202206072\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202206072\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @api
 */
final class NodeValueResolverStaticFactory
{
    public static function create() : NodeValueResolver
    {
        $simpleNameResolver = SimpleNameResolverStaticFactory::create();
        $simpleNodeFinder = new SimpleNodeFinder(new NodeFinder());
        return new NodeValueResolver($simpleNameResolver, new TypeChecker(), $simpleNodeFinder);
    }
}
