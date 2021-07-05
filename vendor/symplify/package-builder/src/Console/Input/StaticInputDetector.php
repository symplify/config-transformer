<?php

declare (strict_types=1);
namespace ConfigTransformer202107050\Symplify\PackageBuilder\Console\Input;

use ConfigTransformer202107050\Symfony\Component\Console\Input\ArgvInput;
final class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new \ConfigTransformer202107050\Symfony\Component\Console\Input\ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
