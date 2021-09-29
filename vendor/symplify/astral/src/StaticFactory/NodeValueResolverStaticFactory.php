<?php

declare (strict_types=1);
namespace ConfigTransformer202109292\Symplify\Astral\StaticFactory;

use ConfigTransformer202109292\PhpParser\NodeFinder;
use ConfigTransformer202109292\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer202109292\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer202109292\Symplify\PackageBuilder\Php\TypeChecker;
final class NodeValueResolverStaticFactory
{
    public static function create() : \ConfigTransformer202109292\Symplify\Astral\NodeValue\NodeValueResolver
    {
        $simpleNameResolver = \ConfigTransformer202109292\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::create();
        $simpleNodeFinder = new \ConfigTransformer202109292\Symplify\Astral\NodeFinder\SimpleNodeFinder(new \ConfigTransformer202109292\Symplify\PackageBuilder\Php\TypeChecker(), new \ConfigTransformer202109292\PhpParser\NodeFinder());
        return new \ConfigTransformer202109292\Symplify\Astral\NodeValue\NodeValueResolver($simpleNameResolver, new \ConfigTransformer202109292\Symplify\PackageBuilder\Php\TypeChecker(), $simpleNodeFinder);
    }
}
