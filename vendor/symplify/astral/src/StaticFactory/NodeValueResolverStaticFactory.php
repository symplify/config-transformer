<?php

declare (strict_types=1);
namespace ConfigTransformer2021112310\Symplify\Astral\StaticFactory;

use ConfigTransformer2021112310\PhpParser\NodeFinder;
use ConfigTransformer2021112310\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer2021112310\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer2021112310\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @api
 */
final class NodeValueResolverStaticFactory
{
    public static function create() : \ConfigTransformer2021112310\Symplify\Astral\NodeValue\NodeValueResolver
    {
        $simpleNameResolver = \ConfigTransformer2021112310\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::create();
        $simpleNodeFinder = new \ConfigTransformer2021112310\Symplify\Astral\NodeFinder\SimpleNodeFinder(new \ConfigTransformer2021112310\Symplify\PackageBuilder\Php\TypeChecker(), new \ConfigTransformer2021112310\PhpParser\NodeFinder());
        return new \ConfigTransformer2021112310\Symplify\Astral\NodeValue\NodeValueResolver($simpleNameResolver, new \ConfigTransformer2021112310\Symplify\PackageBuilder\Php\TypeChecker(), $simpleNodeFinder);
    }
}
