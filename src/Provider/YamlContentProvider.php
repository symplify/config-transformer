<?php

declare (strict_types=1);
namespace ConfigTransformer2021091310\Symplify\ConfigTransformer\Provider;

use ConfigTransformer2021091310\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface;
use ConfigTransformer2021091310\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class YamlContentProvider implements \ConfigTransformer2021091310\Symplify\PhpConfigPrinter\Contract\YamlFileContentProviderInterface
{
    /**
     * @var string|null
     */
    private $yamlContent;
    /**
     * @param string $yamlContent
     */
    public function setContent($yamlContent) : void
    {
        $this->yamlContent = $yamlContent;
    }
    public function getYamlContent() : string
    {
        if ($this->yamlContent === null) {
            throw new \ConfigTransformer2021091310\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->yamlContent;
    }
}
