<?php

declare (strict_types=1);
namespace ConfigTransformer202112319\Symplify\Astral\StaticFactory;

use ConfigTransformer202112319\PhpParser\NodeFinder;
use ConfigTransformer202112319\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202112319\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202112319\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @api
 */
final class NodeValueResolverStaticFactory
{
    public static function create() : \ConfigTransformer202112319\Symplify\Astral\NodeValue\NodeValueResolver
    {
        $simpleNameResolver = \ConfigTransformer202112319\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::create();
        $simpleNodeFinder = new \ConfigTransformer202112319\Symplify\Astral\NodeFinder\SimpleNodeFinder(new \ConfigTransformer202112319\Symplify\PackageBuilder\Php\TypeChecker(), new \ConfigTransformer202112319\PhpParser\NodeFinder());
        return new \ConfigTransformer202112319\Symplify\Astral\NodeValue\NodeValueResolver($simpleNameResolver, new \ConfigTransformer202112319\Symplify\PackageBuilder\Php\TypeChecker(), $simpleNodeFinder);
    }
}
