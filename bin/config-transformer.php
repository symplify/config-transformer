<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202310;

use Symplify\ConfigTransformer\Kernel\ConfigTransformerKernel;
use ConfigTransformerPrefix202310\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun;
$possibleAutoloadPaths = [
    // dependency
    __DIR__ . '/../../../autoload.php',
    // monorepo
    __DIR__ . '/../../../vendor/autoload.php',
    // after split package
    __DIR__ . '/../vendor/autoload.php',
];
foreach ($possibleAutoloadPaths as $possibleAutoloadPath) {
    if (\file_exists($possibleAutoloadPath)) {
        require_once $possibleAutoloadPath;
        break;
    }
}
$scoperAutoloadFilepath = __DIR__ . '/../vendor/scoper-autoload.php';
if (\file_exists($scoperAutoloadFilepath)) {
    require_once $scoperAutoloadFilepath;
}
$kernelBootAndApplicationRun = new KernelBootAndApplicationRun(ConfigTransformerKernel::class);
$kernelBootAndApplicationRun->run();
