<?php

declare (strict_types=1);
namespace ConfigTransformer202201243\Symplify\PhpConfigPrinter\Dummy;

use ConfigTransformer202201243\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
final class YamlContentProvider
{
    /**
     * @var string|null
     */
    private $yamlContent = null;
    public function setContent(string $yamlContent) : void
    {
        $this->yamlContent = $yamlContent;
    }
    public function getYamlContent() : string
    {
        if ($this->yamlContent === null) {
            throw new \ConfigTransformer202201243\Symplify\SymplifyKernel\Exception\ShouldNotHappenException();
        }
        return $this->yamlContent;
    }
}
