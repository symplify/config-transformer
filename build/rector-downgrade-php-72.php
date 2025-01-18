<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withDowngradeSets(php72: true)
    ->withSkip([
        '*/Tests/*',
        '*/tests/*',
        __DIR__ . '/../tests',
        # missing "optional" dependency and never used here
        '*/symfony/framework-bundle/KernelBrowser.php',
        '*/symfony/http-kernel/HttpKernelBrowser.php',
    ]);
