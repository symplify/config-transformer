<?php

declare (strict_types=1);
namespace ConfigTransformer202107245;

use ConfigTransformer202107245\Symplify\EasyTesting\HttpKernel\EasyTestingKernel;
use ConfigTransformer202107245\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun;
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
$kernelBootAndApplicationRun = new \ConfigTransformer202107245\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun(\ConfigTransformer202107245\Symplify\EasyTesting\HttpKernel\EasyTestingKernel::class);
$kernelBootAndApplicationRun->run();
