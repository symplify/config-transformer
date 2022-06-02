<?php

declare (strict_types=1);
namespace ConfigTransformer202206021\Symplify\ConfigTransformer\Kernel;

use ConfigTransformer202206021\Psr\Container\ContainerInterface;
use ConfigTransformer202206021\Symplify\PhpConfigPrinter\ValueObject\PhpConfigPrinterConfig;
use ConfigTransformer202206021\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class ConfigTransformerKernel extends \ConfigTransformer202206021\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202206021\Psr\Container\ContainerInterface
    {
        $configFiles[] = __DIR__ . '/../../config/config.php';
        $configFiles[] = \ConfigTransformer202206021\Symplify\PhpConfigPrinter\ValueObject\PhpConfigPrinterConfig::FILE_PATH;
        return $this->create($configFiles);
    }
}
