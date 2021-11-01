<?php

declare (strict_types=1);
namespace ConfigTransformer202111016\Symplify\Astral\Bundle;

use ConfigTransformer202111016\Symfony\Component\HttpKernel\Bundle\Bundle;
use ConfigTransformer202111016\Symplify\Astral\DependencyInjection\Extension\AstralExtension;
final class AstralBundle extends \ConfigTransformer202111016\Symfony\Component\HttpKernel\Bundle\Bundle
{
    protected function createContainerExtension() : ?\ConfigTransformer202111016\Symfony\Component\DependencyInjection\Extension\ExtensionInterface
    {
        return new \ConfigTransformer202111016\Symplify\Astral\DependencyInjection\Extension\AstralExtension();
    }
}
