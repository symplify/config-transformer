<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\DependencyInjection\Loader;

use ConfigTransformerPrefix202302\Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
/**
 * This is needed to avoid loading the PHP file.
 */
final class SkippingPhpFileLoader extends PhpFileLoader
{
    /**
     * @param mixed $resource
     */
    public function load($resource, string $type = null) : string
    {
        return '';
    }
}
