<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202302;

use Symplify\ConfigTransformer\Kernel\ConfigTransformerKernel;
use ConfigTransformerPrefix202302\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun;
\define('ConfigTransformerPrefix202302\\__CONFIG_TRANSFORMER_RUNNING__', \true);
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
// this allows to easily convert ECS yaml to php configs
$codeSnifferAutoload = \getcwd() . '/vendor/squizlabs/php_codesniffer/autoload.php';
if (\file_exists($codeSnifferAutoload)) {
    require_once $codeSnifferAutoload;
}
$kernelBootAndApplicationRun = new KernelBootAndApplicationRun(ConfigTransformerKernel::class);
$kernelBootAndApplicationRun->run();
