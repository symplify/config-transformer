<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202507;

use ConfigTransformerPrefix202507\Symfony\Component\Console\Input\ArgvInput;
use ConfigTransformerPrefix202507\Symfony\Component\Console\Output\ConsoleOutput;
use Symplify\ConfigTransformer\Console\ConfigTransformerApplication;
use Symplify\ConfigTransformer\Kernel\ConfigTransformerContainerFactory;
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
$configTransformerContainerFactory = new ConfigTransformerContainerFactory();
$container = $configTransformerContainerFactory->create();
/** @var ConfigTransformerApplication $configTransformerApplication */
$configTransformerApplication = $container->get(ConfigTransformerApplication::class);
$input = new ArgvInput();
$output = new ConsoleOutput();
$configTransformerApplication->run($input, $output);
