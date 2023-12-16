<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Kernel;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symplify\PhpConfigPrinter\ValueObject\PhpConfigPrinterConfig;

/**
 * @api used in tests and bin
 */
final class ConfigTransformerKernel extends Kernel
{
    public function __construct()
    {
        parent::__construct('dev', true);
    }

    public function registerBundles(): iterable
    {
        return [];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__ . '/../../config/config.php');
        $loader->load(PhpConfigPrinterConfig::FILE_PATH);
    }
}
