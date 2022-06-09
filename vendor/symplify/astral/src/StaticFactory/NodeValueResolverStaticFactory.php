<?php

declare (strict_types=1);
namespace ConfigTransformer20220609\Symplify\Astral\StaticFactory;

use ConfigTransformer20220609\PhpParser\NodeFinder;
use ConfigTransformer20220609\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer20220609\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer20220609\Symplify\PackageBuilder\Php\TypeChecker;
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
