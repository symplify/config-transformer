<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Provider;

use Migrify\ConfigTransformer\FormatSwitcher\Exception\ShouldNotHappenException;

final class CurrentFilePathProvider
{
    /**
     * @var string|null
     */
    private $filePath;

    public function setFilePath(string $yamlFilePath): void
    {
        $this->filePath = $yamlFilePath;
    }

    public function getFilePath(): string
    {
        if ($this->filePath === null) {
            throw new ShouldNotHappenException();
        }

        return $this->filePath;
    }
}
