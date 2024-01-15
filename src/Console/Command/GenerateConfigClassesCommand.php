<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Console\Command;

use ConfigTransformerPrefix202401\Symfony\Component\Config\Builder\ConfigBuilderGenerator;
use ConfigTransformerPrefix202401\Symfony\Component\Config\Definition\ConfigurationInterface;
use ConfigTransformerPrefix202401\Symfony\Component\Console\Command\Command;
use ConfigTransformerPrefix202401\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformerPrefix202401\Symfony\Component\Console\Output\OutputInterface;
use ConfigTransformerPrefix202401\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformerPrefix202401\Symfony\Component\DependencyInjection\ContainerBuilder;
use ConfigTransformerPrefix202401\Symfony\Component\DependencyInjection\Extension\Extension;
final class GenerateConfigClassesCommand extends Command
{
    /**
     * @var string[]
     */
    private const EXTENSION_CLASSES = ['ConfigTransformerPrefix202401\\Symfony\\Bundle\\FrameworkBundle\\DependencyInjection\\FrameworkExtension', 'ConfigTransformerPrefix202401\\Symfony\\Bundle\\MonologBundle\\DependencyInjection\\MonologExtension', 'ConfigTransformerPrefix202401\\Symfony\\Bundle\\SecurityBundle\\DependencyInjection\\SecurityExtension', 'ConfigTransformerPrefix202401\\Symfony\\Bundle\\TwigBundle\\DependencyInjection\\TwigExtension', 'ConfigTransformerPrefix202401\\Doctrine\\Bundle\\DoctrineBundle\\DependencyInjection\\DoctrineExtension'];
    /**
     * @var \Symfony\Component\Console\Style\SymfonyStyle
     */
    private $symfonyStyle;
    protected function configure() : void
    {
        $this->setName('generate-config-classes');
        $this->setDescription('Generate Symfony config classes to /var/cache/Symfony directory, see https://symfony.com/blog/new-in-symfony-5-3-config-builder-classes');
    }
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $this->symfonyStyle = new SymfonyStyle($input, $output);
        $configBuilderGenerator = new ConfigBuilderGenerator(\getcwd() . '/var/cache');
        $this->symfonyStyle->newLine();
        foreach (self::EXTENSION_CLASSES as $extensionClass) {
            // skip for non-existing classes
            if (!\class_exists($extensionClass)) {
                continue;
            }
            $configuration = $this->createExtensionConfiguration($extensionClass);
            if (!$configuration instanceof ConfigurationInterface) {
                continue;
            }
            $configBuilderGenerator->build($configuration);
        }
        return self::SUCCESS;
    }
    /**
     * @param class-string $extensionClass
     */
    private function createExtensionConfiguration(string $extensionClass) : ?ConfigurationInterface
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->setParameter('kernel.debug', \false);
        /** @var Extension $extension */
        $extension = new $extensionClass();
        return $extension->getConfiguration([], $containerBuilder);
    }
}
