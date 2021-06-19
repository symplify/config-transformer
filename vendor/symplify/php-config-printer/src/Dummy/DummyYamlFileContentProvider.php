<?php

declare (strict_types=1);
namespace ConfigTransformer2021061910\Symplify\PhpConfigPrinter\Dummy;

use ConfigTransformer2021061910\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
final class DummyYamlFileContentProvider implements \ConfigTransformer2021061910\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface
{
    public function setContent(string $yamlContent) : void
    {
    }
    public function getYamlContent() : string
    {
        return '';
    }
}
