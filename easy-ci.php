<?php

declare(strict_types=1);

use Symplify\EasyCI\Config\EasyCIConfig;

return static function (EasyCIConfig $easyCIConfig): void {
    $easyCIConfig->typesToSkip([
        \Symplify\ConfigTransformer\NodeVisitor\RefOrServiceFuncCallPrePrintNodeVisitor::class,
        \Symplify\ConfigTransformer\Console\ConfigTransformerApplication::class,
        \Symplify\ConfigTransformer\Kernel\ConfigTransformerKernel::class,
    ]);
};
