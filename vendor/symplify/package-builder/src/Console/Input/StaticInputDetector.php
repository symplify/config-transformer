<?php

declare (strict_types=1);
namespace ConfigTransformer202209\Symplify\PackageBuilder\Console\Input;

use ConfigTransformer202209\Symfony\Component\Console\Input\ArgvInput;
/**
 * @api
 */
final class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
