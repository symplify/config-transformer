<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\Symplify\Astral\StaticFactory;

use ConfigTransformer2022060710\PhpParser\NodeFinder;
use ConfigTransformer2022060710\Symplify\Astral\NodeFinder\SimpleNodeFinder;
use ConfigTransformer2022060710\Symplify\Astral\NodeValue\NodeValueResolver;
use ConfigTransformer2022060710\Symplify\PackageBuilder\Php\TypeChecker;
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
