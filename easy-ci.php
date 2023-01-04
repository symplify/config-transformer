<?php

declare(strict_types=1);

use Symplify\EasyCI\Config\EasyCIConfig;

return static function (EasyCIConfig $easyCIConfig): void {
    $easyCIConfig->typesToSkip([
        \Symplify\ConfigTransformer\NodeVisitor\RefOrServiceFuncCallPrePrintNodeVisitor::class,
    ]);
};
