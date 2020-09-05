<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\HttpKernel;

use Migrify\MigrifyKernel\Bundle\MigrifyKernelBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Symfony\Component\HttpKernel\Kernel;

final class ConfigTransformerKernel extends Kernel
{
    public function __construct(string $environment, bool $debug)
    {
        // rand is for container rebuild
        parent::__construct($environment . random_int(1, 1000), $debug);
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
    }

    public function getCacheDir(): string
    {
        return sys_get_temp_dir() . '/_migrify_config_transformer';
    }

    public function getLogDir(): string
    {
        return sys_get_temp_dir() . '/_migrify_config_transformer_log';
    }

    /**
     * @return BundleInterface[]
     */
    public function registerBundles(): iterable
    {
        return [new MigrifyKernelBundle()];
    }
}
