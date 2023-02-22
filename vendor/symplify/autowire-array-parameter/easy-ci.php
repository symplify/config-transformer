<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202302;

use ConfigTransformerPrefix202302\Symplify\AutowireArrayParameter\DependencyInjection\CompilerPass\AutowireArrayParameterCompilerPass;
use ConfigTransformerPrefix202302\Symplify\EasyCI\Config\EasyCIConfig;
return static function (EasyCIConfig $easyCIConfig) : void {
    $easyCIConfig->typesToSkip([AutowireArrayParameterCompilerPass::class]);
};
