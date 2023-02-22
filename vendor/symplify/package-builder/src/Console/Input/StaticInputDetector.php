<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202302\Symplify\PackageBuilder\Console\Input;

use ConfigTransformerPrefix202302\Symfony\Component\Console\Input\ArgvInput;
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
