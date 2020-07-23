<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FeatureShifter\Utils;

final class StaticArrays
{
    /**
     * @param mixed[] $items
     */
    public static function hasOnlyKey(array $items, string $key): bool
    {
        if (count($items) !== 1) {
            return false;
        }

        return isset($items[$key]);
    }
}
