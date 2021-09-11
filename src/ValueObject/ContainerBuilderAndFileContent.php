<?php

declare (strict_types=1);
namespace ConfigTransformer202109117\Symplify\ConfigTransformer\ValueObject;

use ConfigTransformer202109117\Symfony\Component\DependencyInjection\ContainerBuilder;
final class ContainerBuilderAndFileContent
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    private $containerBuilder;
    /**
     * @var string
     */
    private $fileContent;
    public function __construct(\ConfigTransformer202109117\Symfony\Component\DependencyInjection\ContainerBuilder $containerBuilder, string $fileContent)
    {
        $this->containerBuilder = $containerBuilder;
        $this->fileContent = $fileContent;
    }
    public function getContainerBuilder() : \ConfigTransformer202109117\Symfony\Component\DependencyInjection\ContainerBuilder
    {
        return $this->containerBuilder;
    }
    public function getFileContent() : string
    {
        return $this->fileContent;
    }
}
