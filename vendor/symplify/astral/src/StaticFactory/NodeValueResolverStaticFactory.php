<?php

declare (strict_types=1);
namespace ConfigTransformer202110116\Symplify\Astral\StaticFactory;

use ConfigTransformer202110116\PhpParser\NodeFinder;
use ConfigTransformer202110116\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202110116\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202110116\Symplify\PackageBuilder\Php\TypeChecker;
final class NodeValueResolverStaticFactory
{
    public static function create() : \ConfigTransformer202110116\Symplify\Astral\NodeValue\NodeValueResolver
    {
        $simpleNameResolver = \ConfigTransformer202110116\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::create();
        $simpleNodeFinder = new \ConfigTransformer202110116\Symplify\Astral\NodeFinder\SimpleNodeFinder(new \ConfigTransformer202110116\Symplify\PackageBuilder\Php\TypeChecker(), new \ConfigTransformer202110116\PhpParser\NodeFinder());
        return new \ConfigTransformer202110116\Symplify\Astral\NodeValue\NodeValueResolver($simpleNameResolver, new \ConfigTransformer202110116\Symplify\PackageBuilder\Php\TypeChecker(), $simpleNodeFinder);
    }
}
