<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Console\Command;

use Symfony\Component\Config\Builder\ConfigBuilderGenerator;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

final class GenerateConfigClassesCommand extends Command
{
    /**
     * @var string[]
     */
    private const EXTENSION_CLASSES = [
        'Symfony\Bundle\FrameworkBundle\DependencyInjection\FrameworkExtension',
        'Symfony\Bundle\MonologBundle\DependencyInjection\MonologExtension',
        'Symfony\Bundle\SecurityBundle\DependencyInjection\SecurityExtension',
        'Symfony\Bundle\TwigBundle\DependencyInjection\TwigExtension',
        'Doctrine\Bundle\DoctrineBundle\DependencyInjection\DoctrineExtension',
    ];

    private SymfonyStyle $symfonyStyle;

    protected function configure(): void
    {
        $this->setName('generate-config-classes');
        $this->setDescription('Generate Symfony config classes to /var/cache/Symfony directory, see https://symfony.com/blog/new-in-symfony-5-3-config-builder-classes');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->symfonyStyle = new SymfonyStyle($input, $output);

        $configBuilderGenerator = new ConfigBuilderGenerator(getcwd() . '/var/cache');
        $this->symfonyStyle->newLine();

        foreach (self::EXTENSION_CLASSES as $extensionClass) {
            // skip for non-existing classes
            if (! class_exists($extensionClass)) {
                continue;
            }

            $configuration = $this->createExtensionConfiguration($extensionClass);
            if (! $configuration instanceof ConfigurationInterface) {
                continue;
            }

            $configBuilderGenerator->build($configuration);
        }

        return self::SUCCESS;
    }

    /**
     * @param class-string $extensionClass
     */
    private function createExtensionConfiguration(string $extensionClass): ?ConfigurationInterface
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->setParameter('kernel.debug', false);

        /** @var Extension $extension */
        $extension = new $extensionClass();

        return $extension->getConfiguration([], $containerBuilder);
    }
}

