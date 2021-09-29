<?php

declare (strict_types=1);
namespace ConfigTransformer202109297\Symplify\Astral\StaticFactory;

use ConfigTransformer202109297\PhpParser\NodeFinder;
use ConfigTransformer202109297\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202109297\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202109297\Symplify\PackageBuilder\Php\TypeChecker;
final class NodeValueResolverStaticFactory
{
    public static function create() : \ConfigTransformer202109297\Symplify\Astral\NodeValue\NodeValueResolver
    {
        $simpleNameResolver = \ConfigTransformer202109297\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::create();
        $simpleNodeFinder = new \ConfigTransformer202109297\Symplify\Astral\NodeFinder\SimpleNodeFinder(new \ConfigTransformer202109297\Symplify\PackageBuilder\Php\TypeChecker(), new \ConfigTransformer202109297\PhpParser\NodeFinder());
        return new \ConfigTransformer202109297\Symplify\Astral\NodeValue\NodeValueResolver($simpleNameResolver, new \ConfigTransformer202109297\Symplify\PackageBuilder\Php\TypeChecker(), $simpleNodeFinder);
    }
}
