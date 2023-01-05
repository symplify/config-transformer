<?php

declare (strict_types=1);
namespace ConfigTransformer202301;

use ConfigTransformer202301\Symplify\MonorepoBuilder\Config\MBConfig;
return static function (MBConfig $mbConfig) : void {
    $mbConfig->packageDirectories([__DIR__ . '/packages']);
};
