<?php

declare (strict_types=1);
namespace ConfigTransformer202111287\Symplify\ConfigTransformer\Kernel;

use ConfigTransformer202111287\Psr\Container\ContainerInterface;
use ConfigTransformer202111287\Symplify\PhpConfigPrinter\ValueObject\PhpConfigPrinterConfig;
use ConfigTransformer202111287\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class ConfigTransformerKernel extends \ConfigTransformer202111287\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs($configFiles) : \ConfigTransformer202111287\Psr\Container\ContainerInterface
    {
        $configFiles[] = __DIR__ . '/../../config/config.php';
        $configFiles[] = \ConfigTransformer202111287\Symplify\PhpConfigPrinter\ValueObject\PhpConfigPrinterConfig::FILE_PATH;
        return $this->create([], [], $configFiles);
    }
}
