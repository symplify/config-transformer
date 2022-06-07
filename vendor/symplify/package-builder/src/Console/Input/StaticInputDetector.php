<?php

declare (strict_types=1);
namespace ConfigTransformer2022060710\Symplify\PackageBuilder\Console\Input;

use ConfigTransformer2022060710\Symfony\Component\Console\Input\ArgvInput;
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
