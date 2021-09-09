<?php

declare (strict_types=1);
namespace ConfigTransformer202109098;

use ConfigTransformer202109098\Symplify\EasyTesting\HttpKernel\EasyTestingKernel;
use ConfigTransformer202109098\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun;
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
$kernelBootAndApplicationRun = new \ConfigTransformer202109098\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun(\ConfigTransformer202109098\Symplify\EasyTesting\HttpKernel\EasyTestingKernel::class);
$kernelBootAndApplicationRun->run();
