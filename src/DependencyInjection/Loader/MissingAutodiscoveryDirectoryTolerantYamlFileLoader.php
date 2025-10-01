<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\DependencyInjection\Loader;

use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class MissingAutodiscoveryDirectoryTolerantYamlFileLoader extends YamlFileLoader
{
    public function registerClasses(
        Definition $definition,
        string $namespace,
        string $resource,
        string|array|null $exclude = null
    ): void {
        // skip loading classes, as the resource might not exist and invoke autoloading
    }
}
