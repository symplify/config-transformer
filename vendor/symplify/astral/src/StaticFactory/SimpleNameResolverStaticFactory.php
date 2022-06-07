<?php

declare (strict_types=1);
namespace ConfigTransformer202206079\Symplify\Astral\StaticFactory;

use ConfigTransformer202206079\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer202206079\Symplify\Astral\NodeNameResolver\ArgNodeNameResolver;
use ConfigTransformer202206079\Symplify\Astral\NodeNameResolver\AttributeNodeNameResolver;
use ConfigTransformer202206079\Symplify\Astral\NodeNameResolver\ClassLikeNodeNameResolver;
use ConfigTransformer202206079\Symplify\Astral\NodeNameResolver\ClassMethodNodeNameResolver;
use ConfigTransformer202206079\Symplify\Astral\NodeNameResolver\ConstFetchNodeNameResolver;
use ConfigTransformer202206079\Symplify\Astral\NodeNameResolver\FuncCallNodeNameResolver;
use ConfigTransformer202206079\Symplify\Astral\NodeNameResolver\IdentifierNodeNameResolver;
use ConfigTransformer202206079\Symplify\Astral\NodeNameResolver\NamespaceNodeNameResolver;
use ConfigTransformer202206079\Symplify\Astral\NodeNameResolver\ParamNodeNameResolver;
use ConfigTransformer202206079\Symplify\Astral\NodeNameResolver\PropertyNodeNameResolver;
/**
 * This would be normally handled by standard Symfony or Nette DI, but PHPStan does not use any of those, so we have to
 * make it manually.
 */
final class SimpleNameResolverStaticFactory
{
    public static function create() : SimpleNameResolver
    {
        $nameResolvers = [new ArgNodeNameResolver(), new AttributeNodeNameResolver(), new ClassLikeNodeNameResolver(), new ClassMethodNodeNameResolver(), new ConstFetchNodeNameResolver(), new FuncCallNodeNameResolver(), new IdentifierNodeNameResolver(), new NamespaceNodeNameResolver(), new ParamNodeNameResolver(), new PropertyNodeNameResolver()];
        return new SimpleNameResolver($nameResolvers);
    }
}
