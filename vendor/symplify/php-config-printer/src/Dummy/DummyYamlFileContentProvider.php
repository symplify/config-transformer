<?php

declare (strict_types=1);
namespace ConfigTransformer202106110\Symplify\PhpConfigPrinter\Dummy;

use ConfigTransformer202106110\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
final class DummyYamlFileContentProvider implements \ConfigTransformer202106110\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface
{
    public function setContent(string $yamlContent) : void
    {
    }
    public function getYamlContent() : string
    {
        return '';
    }
}