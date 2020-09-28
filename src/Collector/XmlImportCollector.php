<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\Collector;

use Migrify\PhpConfigPrinter\ValueObject\YamlKey;

final class XmlImportCollector
{
    /**
     * @var array
     */
    private $imports = [];

    public function addImport($resource, $ignoreErrors): void
    {
        $this->imports[] = [
            YamlKey::RESOURCE => $resource,
            YamlKey::IGNORE_ERRORS => $ignoreErrors,
        ];
    }

    public function provide(): array
    {
        return $this->imports;
    }
}
