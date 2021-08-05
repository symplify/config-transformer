<?php

declare (strict_types=1);
namespace ConfigTransformer2021080510\Symplify\PhpConfigPrinter\Dummy;

use ConfigTransformer2021080510\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
final class DummyYamlFileContentProvider implements \ConfigTransformer2021080510\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface
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
