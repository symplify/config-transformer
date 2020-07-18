<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Yaml;

use Nette\Utils\Strings;

final class YamlListCommentRemover
{
    public function remove(string $yamlContent): string
    {
        $yamlContentLines = explode(PHP_EOL, $yamlContent);
        $yamlContentLines = array_filter($yamlContentLines);

        $keysToRemove = [];

        foreach ($yamlContentLines as $key => $line) {
            if (! $this->isCommentLine($line)) {
                continue;
            }

            if (! $this->isNextLineOrPreviousLineListItem($yamlContentLines, $key)) {
                continue;
            }

            $keysToRemove[] = $key;
        }

        $yamlContentLines = $this->removeLinesByKeys($yamlContentLines, $keysToRemove);

        return implode(PHP_EOL, $yamlContentLines);
    }

    private function isCommentLine(string $line): bool
    {
        $trimmedLine = trim($line);

        return Strings::startsWith($trimmedLine, '#');
    }

    /**
     * @param string[] $yamlContentLines
     */
    private function isNextLineOrPreviousLineListItem(array $yamlContentLines, int $key): bool
    {
        if ($this->isPreviousLineListItem($yamlContentLines, $key)) {
            return true;
        }

        return $this->isNextLineListItem($yamlContentLines, $key);
    }

    private function isNextLineListItem(array $lines, int $key): bool
    {
        ++$key;

        while (isset($lines[$key])) {
            $line = $lines[$key];

            if ($this->isCommentLine($line)) {
                ++$key;
                continue;
            }

            return $this->isListLine($line);
        }

        return false;
    }

    private function isPreviousLineListItem(array $lines, int $key): bool
    {
        --$key;

        while (isset($lines[$key])) {
            $line = $lines[$key];

            if ($this->isCommentLine($line)) {
                --$key;
                continue;
            }

            return $this->isListLine($line);
        }

        return false;
    }

    private function isListLine(string $line): bool
    {
        $trimmedLine = trim($line);
        return Strings::startsWith($trimmedLine, '- ');
    }

    /**
     * @param string[] $yamlContentLines
     * @param int[] $keysToRemove
     * @return string[]
     */
    private function removeLinesByKeys(array $yamlContentLines, array $keysToRemove): array
    {
        foreach (array_keys($yamlContentLines) as $key) {
            if (! in_array($key, $keysToRemove, true)) {
                continue;
            }

            unset($yamlContentLines[$key]);
        }

        return $yamlContentLines;
    }
}
