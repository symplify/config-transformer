<?php

declare (strict_types=1);
namespace ConfigTransformer202206075\Symplify\PackageBuilder\Console\Input;

use ConfigTransformer202206075\Symfony\Component\Console\Input\ArgvInput;
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
