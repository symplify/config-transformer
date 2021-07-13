<?php

declare (strict_types=1);
namespace ConfigTransformer202107138\Symplify\PhpConfigPrinter\Dummy;

use ConfigTransformer202107138\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
final class DummyYamlFileContentProvider implements \ConfigTransformer202107138\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface
{
    /**
     * @param string $yamlContent
     */
    public function setContent($yamlContent) : void
    {
    }
    public function getYamlContent() : string
    {
        return '';
    }
}
