<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\HttpKernel;

use Migrify\MigrifyKernel\HttpKernel\AbstractMigrifyKernel;
use Symfony\Component\Config\Loader\LoaderInterface;

final class ConfigTransformerKernel extends AbstractMigrifyKernel
{
    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }
}
