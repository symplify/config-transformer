<?php

declare (strict_types=1);
namespace ConfigTransformer202201310\Symplify\PackageBuilder\Console\Input;

use ConfigTransformer202201310\Symfony\Component\Console\Input\ArgvInput;
/**
 * @api
 */
final class StaticInputDetector
{
    public static function isDebug() : bool
    {
        $argvInput = new \ConfigTransformer202201310\Symfony\Component\Console\Input\ArgvInput();
        return $argvInput->hasParameterOption(['--debug', '-v', '-vv', '-vvv']);
    }
}
