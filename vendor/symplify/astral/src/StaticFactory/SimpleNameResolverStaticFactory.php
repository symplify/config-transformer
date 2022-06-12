<?php

declare (strict_types=1);
namespace ConfigTransformer20220612\Symplify\Astral\StaticFactory;

use ConfigTransformer20220612\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer20220612\Symplify\Astral\NodeNameResolver\ArgNodeNameResolver;
use ConfigTransformer20220612\Symplify\Astral\NodeNameResolver\AttributeNodeNameResolver;
use ConfigTransformer20220612\Symplify\Astral\NodeNameResolver\ClassLikeNodeNameResolver;
use ConfigTransformer20220612\Symplify\Astral\NodeNameResolver\ClassMethodNodeNameResolver;
use ConfigTransformer20220612\Symplify\Astral\NodeNameResolver\ConstFetchNodeNameResolver;
use ConfigTransformer20220612\Symplify\Astral\NodeNameResolver\FuncCallNodeNameResolver;
use ConfigTransformer20220612\Symplify\Astral\NodeNameResolver\IdentifierNodeNameResolver;
use ConfigTransformer20220612\Symplify\Astral\NodeNameResolver\NamespaceNodeNameResolver;
use ConfigTransformer20220612\Symplify\Astral\NodeNameResolver\ParamNodeNameResolver;
use ConfigTransformer20220612\Symplify\Astral\NodeNameResolver\PropertyNodeNameResolver;
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
