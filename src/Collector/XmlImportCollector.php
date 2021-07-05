<?php

declare (strict_types=1);
namespace ConfigTransformer202107054\Symplify\ConfigTransformer\Collector;

use ConfigTransformer202107054\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
final class XmlImportCollector
{
    /**
     * @var array<string, array<string, mixed>>|string[]
     */
    private $imports = [];
    public function addImport($resource, $ignoreErrors) : void
    {
        $this->imports[] = [\ConfigTransformer202107054\Symplify\PhpConfigPrinter\ValueObject\YamlKey::RESOURCE => $resource, \ConfigTransformer202107054\Symplify\PhpConfigPrinter\ValueObject\YamlKey::IGNORE_ERRORS => $ignoreErrors];
    }
    /**
     * @return mixed[]
     */
    public function provide() : array
    {
        return $this->imports;
    }
}
