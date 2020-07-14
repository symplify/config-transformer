<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Provider;

use Migrify\ConfigTransformer\FormatSwitcher\Exception\ShouldNotHappenException;

final class YamlContentProvider
{
    /**
     * @var string|null
     */
    private $yamlContent;

    public function setContent(string $yamlContent): void
    {
        $this->yamlContent = $yamlContent;
    }

    public function getYamlContent(): string
    {
        if ($this->yamlContent === null) {
            throw new ShouldNotHappenException();
        }

        return $this->yamlContent;
    }
}
