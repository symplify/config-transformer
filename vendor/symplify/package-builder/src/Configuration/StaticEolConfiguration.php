<?php

declare (strict_types=1);
namespace ConfigTransformer20210606\Symplify\PackageBuilder\Configuration;

final class StaticEolConfiguration
{
    public static function getEolChar() : string
    {
        return "\n";
    }
}
