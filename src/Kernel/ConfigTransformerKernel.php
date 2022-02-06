<?php

declare (strict_types=1);
namespace ConfigTransformer202202064\Symplify\ConfigTransformer\Kernel;

use ConfigTransformer202202064\Psr\Container\ContainerInterface;
use ConfigTransformer202202064\Symplify\PhpConfigPrinter\ValueObject\PhpConfigPrinterConfig;
use ConfigTransformer202202064\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class ConfigTransformerKernel extends \ConfigTransformer202202064\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : \ConfigTransformer202202064\Psr\Container\ContainerInterface
    {
        $configFiles[] = __DIR__ . '/../../config/config.php';
        $configFiles[] = \ConfigTransformer202202064\Symplify\PhpConfigPrinter\ValueObject\PhpConfigPrinterConfig::FILE_PATH;
        return $this->create($configFiles);
    }
}
