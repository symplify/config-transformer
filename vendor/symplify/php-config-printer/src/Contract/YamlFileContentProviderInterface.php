<?php

declare (strict_types=1);
namespace ConfigTransformer202109216\Symplify\PhpConfigPrinter\Contract;

interface YamlFileContentProviderInterface
{
    /**
     * @param string $yamlContent
     */
    public function setContent($yamlContent) : void;
    public function getYamlContent() : string;
}
