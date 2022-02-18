<?php

declare (strict_types=1);
namespace ConfigTransformer202202183\Symplify\Astral\StaticFactory;

use ConfigTransformer202202183\PhpParser\NodeFinder;
use ConfigTransformer202202183\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202202183\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202202183\Symplify\PackageBuilder\Php\TypeChecker;
/**
 * @api
 */
final class NodeValueResolverStaticFactory
{
    public static function create() : \ConfigTransformer202202183\Symplify\Astral\NodeValue\NodeValueResolver
    {
        $simpleNameResolver = \ConfigTransformer202202183\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::create();
        $simpleNodeFinder = new \ConfigTransformer202202183\Symplify\Astral\NodeFinder\SimpleNodeFinder(new \ConfigTransformer202202183\PhpParser\NodeFinder());
        return new \ConfigTransformer202202183\Symplify\Astral\NodeValue\NodeValueResolver($simpleNameResolver, new \ConfigTransformer202202183\Symplify\PackageBuilder\Php\TypeChecker(), $simpleNodeFinder);
    }
}
