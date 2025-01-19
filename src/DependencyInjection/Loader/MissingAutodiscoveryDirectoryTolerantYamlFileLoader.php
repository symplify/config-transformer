<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\DependencyInjection\Loader;

use ConfigTransformerPrefix202501\Symfony\Component\DependencyInjection\Definition;
use ConfigTransformerPrefix202501\Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
final class MissingAutodiscoveryDirectoryTolerantYamlFileLoader extends YamlFileLoader
{
    /**
     * @param string|mixed[] $exclude
     */
    public function registerClasses(Definition $definition, string $namespace, string $resource, $exclude = null) : void
    {
        // skip loading classes, as the resource might not exist and invoke autoloading
    }
}
