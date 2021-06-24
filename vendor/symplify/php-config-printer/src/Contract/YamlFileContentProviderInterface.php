<?php

declare (strict_types=1);
namespace ConfigTransformer202106246\Symplify\PhpConfigPrinter\Contract;

interface YamlFileContentProviderInterface
{
    public function setContent(string $yamlContent) : void;
    public function getYamlContent() : string;
}
