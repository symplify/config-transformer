<?php

declare (strict_types=1);
namespace ConfigTransformer202206021\Symplify\PackageBuilder\Console\Input;

use ConfigTransformer202206021\Symfony\Component\Console\Input\ArgvInput;
/**
 * @api
 */
final class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new \ConfigTransformer202206021\Symfony\Component\Console\Input\ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
