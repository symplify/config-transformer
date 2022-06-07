<?php

declare (strict_types=1);
namespace ConfigTransformer20220607\Symplify\Astral\StaticFactory;

use ConfigTransformer20220607\PhpParser\NodeFinder;
use ConfigTransformer20220607\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer20220607\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer20220607\Symplify\PackageBuilder\Php\TypeChecker;
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
