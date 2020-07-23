<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Sorter;

final class YamlArgumentSorter
{
    /**
     * @param array $inOrderKeys Pass an array of keys to sort if exists
     *                           or an associative array following this logic [$key => $valueIfNotExists]
     *
     * @return array
     */
    public function sortArgumentsByKeyIfExists(array $arrayToSort, array $inOrderKeys)
    {
        $argumentsInOrder = [];

        if ($this->isAssociativeArray($inOrderKeys)) {
            foreach ($inOrderKeys as $key => $valueIfNotExists) {
                $argumentsInOrder[$key] = $arrayToSort[$key] ?? $valueIfNotExists;
            }

            return $argumentsInOrder;
        }

        foreach ($inOrderKeys as $key) {
            if (isset($arrayToSort[$key])) {
                $argumentsInOrder[] = $arrayToSort[$key];
            }
        }

        return $argumentsInOrder;
    }

    private function isAssociativeArray(array $array): bool
    {
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
