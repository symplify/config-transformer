<?php

declare (strict_types=1);
namespace Symplify\PhpConfigPrinter\Dummy;

use ConfigTransformer20220613\Symplify\SymplifyKernel\Exception\ShouldNotHappenException;
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
            throw new ShouldNotHappenException();
        }
        return $this->yamlContent;
    }
}
