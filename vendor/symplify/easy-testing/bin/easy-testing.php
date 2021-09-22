<?php

declare (strict_types=1);
namespace ConfigTransformer2021092210;

use ConfigTransformer2021092210\Symplify\EasyTesting\HttpKernel\EasyTestingKernel;
use ConfigTransformer2021092210\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun;
$possibleAutoloadPaths = [
    // dependency
    __DIR__ . '/../../../autoload.php',
    // after split package
    __DIR__ . '/../vendor/autoload.php',
    // monorepo
    __DIR__ . '/../../../vendor/autoload.php',
];
foreach ($possibleAutoloadPaths as $possibleAutoloadPath) {
    if (\file_exists($possibleAutoloadPath)) {
        require_once $possibleAutoloadPath;
        break;
    }
}
$kernelBootAndApplicationRun = new \ConfigTransformer2021092210\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun(\ConfigTransformer2021092210\Symplify\EasyTesting\HttpKernel\EasyTestingKernel::class);
$kernelBootAndApplicationRun->run();
