<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202310;

use ConfigTransformerPrefix202310\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformerPrefix202310\Symplify\EasyCI\Config\EasyCIConfig;
return static function (EasyCIConfig $easyCIConfig) : void {
    $easyCIConfig->typesToSkip([AutowireArrayParameterCompilerPass::class]);
};
