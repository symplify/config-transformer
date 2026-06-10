<?php

declare(strict_types=1);

namespace Symplify\PhpConfigPrinter;

use Nette\Utils\Strings;

/**
 * @api
 */
final class StringFormatConverter
{
    /**
     * @var string
     * @see https://regex101.com/r/rl1nvl/1
     */
    private const BIG_LETTER_REGEX = '#([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]*)#';

    public static function underscoreAndHyphenToCamelCase(string $value): string
    {
        $underscoreToHyphensValue = str_replace(['_', '-'], ' ', $value);
        $uppercasedWords = ucwords($underscoreToHyphensValue);
        $value = str_replace(' ', '', $uppercasedWords);

        return lcfirst($value);
    }

    public static function camelCaseToUnderscore(string $input): string
    {
        return self::camelCaseToGlue($input, '_');
    }

    public static function camelCaseToDashed(string $input): string
    {
        return self::camelCaseToGlue($input, '-');
    }

    /**
     * @param array<int|string, mixed> $items
     * @return array<int|string, mixed>
     */
    public static function camelCaseToUnderscoreInArrayKeys(array $items): array
    {
        foreach ($items as $key => $value) {
            if (! is_string($key)) {
                continue;
            }

            $newKey = self::camelCaseToUnderscore($key);
            if ($key === $newKey) {
                continue;
            }

            $items[$newKey] = $value;
            unset($items[$key]);
        }

        return $items;
    }

    private static function camelCaseToGlue(string $input, string $glue): string
    {
        $matches = Strings::matchAll($input, self::BIG_LETTER_REGEX);

        $parts = [];
        foreach ($matches as $match) {
            $parts[] = $match[0] === strtoupper((string) $match[0]) ? strtolower($match[0]) : lcfirst(
                (string) $match[0]
            );
        }

        return implode($glue, $parts);
    }
}
