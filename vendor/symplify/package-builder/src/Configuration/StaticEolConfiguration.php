<?php

declare (strict_types=1);
namespace ConfigTransformer202111277\Symplify\PackageBuilder\Configuration;

/**
 * @api
 */
final class StaticEolConfiguration
{
    public static function getEolChar() : string
    {
        return "\n";
    }
}
