<?php

declare (strict_types=1);
namespace ConfigTransformer20210606\Symplify\PackageBuilder\Console\Input;

use ConfigTransformer20210606\Symfony\Component\Console\Input\ArgvInput;
final class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new \ConfigTransformer20210606\Symfony\Component\Console\Input\ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
