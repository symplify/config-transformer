<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Kernel;

use ConfigTransformer20220608\Psr\Container\ContainerInterface;
use Symplify\PhpConfigPrinter\ValueObject\PhpConfigPrinterConfig;
use ConfigTransformer20220608\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class ConfigTransformerKernel extends AbstractSymplifyKernel
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : ContainerInterface
    {
        $configFiles[] = __DIR__ . '/../../config/config.php';
        $configFiles[] = PhpConfigPrinterConfig::FILE_PATH;
        return $this->create($configFiles);
    }
}
