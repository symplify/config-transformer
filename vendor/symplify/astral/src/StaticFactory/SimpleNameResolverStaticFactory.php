<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\Symplify\Astral\StaticFactory;

use ConfigTransformer2022060710\Symplify\Astral\Naming\SimpleNameResolver;
use ConfigTransformer2022060710\Symplify\Astral\NodeNameResolver\ArgNodeNameResolver;
use ConfigTransformer2022060710\Symplify\Astral\NodeNameResolver\AttributeNodeNameResolver;
use ConfigTransformer2022060710\Symplify\Astral\NodeNameResolver\ClassLikeNodeNameResolver;
use ConfigTransformer2022060710\Symplify\Astral\NodeNameResolver\ClassMethodNodeNameResolver;
use ConfigTransformer2022060710\Symplify\Astral\NodeNameResolver\ConstFetchNodeNameResolver;
use ConfigTransformer2022060710\Symplify\Astral\NodeNameResolver\FuncCallNodeNameResolver;
use ConfigTransformer2022060710\Symplify\Astral\NodeNameResolver\IdentifierNodeNameResolver;
use ConfigTransformer2022060710\Symplify\Astral\NodeNameResolver\NamespaceNodeNameResolver;
use ConfigTransformer2022060710\Symplify\Astral\NodeNameResolver\ParamNodeNameResolver;
use ConfigTransformer2022060710\Symplify\Astral\NodeNameResolver\PropertyNodeNameResolver;
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
