<?php

declare (strict_types=1);
namespace ConfigTransformer202107054\Symplify\PackageBuilder\Configuration;

final class StaticEolConfiguration
{
    public static function getEolChar() : string
    {
        return "\n";
    }
}
