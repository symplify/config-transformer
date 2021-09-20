<?php

declare (strict_types=1);
namespace ConfigTransformer202109202\Symplify\PackageBuilder\Configuration;

final class StaticEolConfiguration
{
    public static function getEolChar() : string
    {
        return "\n";
    }
}
