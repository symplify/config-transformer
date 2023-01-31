<?php

declare(strict_types=1);

use Symfony\Component\Console\Application;
use Symplify\EasyCI\Config\EasyCIConfig;
use Symplify\PhpConfigPrinter\Contract\NodeVisitor\PrePrintNodeVisitorInterface;

return static function (EasyCIConfig $easyCIConfig): void {
    $easyCIConfig->typesToSkip([
        PrePrintNodeVisitorInterface::class,
        Application::class,
    ]);
};
