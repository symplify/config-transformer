<?php

declare (strict_types=1);
namespace ConfigTransformer202205015\Symplify\Astral\StaticFactory;

use ConfigTransformer202205015\PhpParser\NodeFinder;
use ConfigTransformer202205015\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202205015\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202205015\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @api
 */
final class NodeValueResolverStaticFactory
{
    public static function create() : \ConfigTransformer202205015\Symplify\Astral\NodeValue\NodeValueResolver
    {
        $simpleNameResolver = \ConfigTransformer202205015\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::create();
        $simpleNodeFinder = new \ConfigTransformer202205015\Symplify\Astral\NodeFinder\SimpleNodeFinder(new \ConfigTransformer202205015\PhpParser\NodeFinder());
        return new \ConfigTransformer202205015\Symplify\Astral\NodeValue\NodeValueResolver($simpleNameResolver, new \ConfigTransformer202205015\Symplify\PackageBuilder\Php\TypeChecker(), $simpleNodeFinder);
    }
}
