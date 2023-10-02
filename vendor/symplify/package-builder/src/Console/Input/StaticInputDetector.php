<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202310\Symplify\PackageBuilder\Console\Input;

use ConfigTransformerPrefix202310\Symfony\Component\Console\Input\ArgvInput;
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
