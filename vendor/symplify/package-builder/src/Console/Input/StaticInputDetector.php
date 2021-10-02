<?php

declare (strict_types=1);
namespace ConfigTransformer202110028\Symplify\PackageBuilder\Console\Input;

use ConfigTransformer202110028\Symfony\Component\Console\Input\ArgvInput;
final class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new \ConfigTransformer202110028\Symfony\Component\Console\Input\ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
