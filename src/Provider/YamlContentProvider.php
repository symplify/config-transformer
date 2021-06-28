<?php

declare (strict_types=1);
namespace ConfigTransformer202106280\Symplify\ConfigTransformer\Provider;

use ConfigTransformer202106280\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
use ConfigTransformer202106280\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class YamlContentProvider implements \ConfigTransformer202106280\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface
{
    /**
     * @var string|null
     */
    private $yamlContent;
    public function setContent(string $yamlContent) : void
    {
        $this->yamlContent = $yamlContent;
    }
    public function getYamlContent() : string
    {
        if ($this->yamlContent === null) {
            throw new \ConfigTransformer202106280\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->yamlContent;
    }
}
