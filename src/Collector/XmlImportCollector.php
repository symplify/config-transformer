<?php

declare (strict_types=1);
namespace ConfigTransformer2021092210\Symplify\ConfigTransformer\Collector;

use ConfigTransformer2021092210\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class XmlImportCollector
{
    /**
     * @var array<string, array<string, mixed>>|string[]
     */
    private $imports = [];
    public function addImport($resource, $ignoreErrors) : void
    {
        $this->imports[] = [\ConfigTransformer2021092210\Symplify\PhpConfigPrinter\ValueObject\YamlKey::RESOURCE => $resource, \ConfigTransformer2021092210\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS => $ignoreErrors];
    }
    /**
     * @return mixed[]
     */
    public function provide() : array
    {
        return $this->imports;
    }
}
