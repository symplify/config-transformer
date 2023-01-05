<?php

declare (strict_types=1);
namespace ConfigTransformer202301;

use ConfigTransformer202301\Symplify\EasyCI\Config\EasyCIConfig;
return static function (EasyCIConfig $easyCIConfig) : void {
    $easyCIConfig->typesToSkip([\ConfigTransformer202301\Symplify\MonorepoBuilder\Config\MBConfig::class, \ConfigTransformer202301\Symplify\MonorepoBuilder\ConflictingUpdater::class, \ConfigTransformer202301\Symplify\MonorepoBuilder\Exception\Git\InvalidGitVersionException::class, \ConfigTransformer202301\Symplify\MonorepoBuilder\Exception\MissingComposerJsonException::class, \ConfigTransformer202301\Symplify\MonorepoBuilder\Git\MostRecentTagResolver::class, \ConfigTransformer202301\Symplify\MonorepoBuilder\Package\PackageNamesProvider::class, \ConfigTransformer202301\Symplify\MonorepoBuilder\Console\MonorepoBuilderApplication::class, \ConfigTransformer202301\Symplify\MonorepoBuilder\Kernel\MonorepoBuilderKernel::class]);
};
