<?php

declare (strict_types=1);
namespace ConfigTransformer2021062210\Symplify\PackageBuilder\Console\Input;

use ConfigTransformer2021062210\Symfony\Component\Console\Input\ArgvInput;
final class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new \ConfigTransformer2021062210\Symfony\Component\Console\Input\ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
