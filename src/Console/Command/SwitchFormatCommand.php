<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Console\Command;

use Nette\Utils\FileSystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symplify\ConfigTransformer\Configuration\ConfigurationFactory;
use Symplify\ConfigTransformer\Converter\ConfigFormatConverter;
use Symplify\ConfigTransformer\FileSystem\ConfigFileDumper;
use Symplify\ConfigTransformer\Finder\ConfigFileFinder;
use Symplify\ConfigTransformer\ValueObject\Configuration;
use Symplify\ConfigTransformer\ValueObject\ConvertedContent;
use Symplify\ConfigTransformer\ValueObject\Option;

final class SwitchFormatCommand extends Command
{
    public function __construct(
        private readonly ConfigurationFactory $configurationFactory,
        private readonly ConfigFileDumper $configFileDumper,
        private readonly ConfigFormatConverter $configFormatConverter,
        private readonly ConfigFileFinder $configFileFinder,
        private readonly SymfonyStyle $symfonyStyle,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('switch-format');
        $this->setAliases(['convert', 'transform']);

        $this->setDescription('Converts YAML configs to PHP format');

        $this->addArgument(
            Option::SOURCES,
            InputArgument::IS_ARRAY,
            'Path to directory/file with configs'
        );

        $this->addOption(Option::DRY_RUN, null, InputOption::VALUE_NONE, 'Dry run - no removal or config change');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $configuration = $this->configurationFactory->createFromInput($input);
        $totalFileCount = $this->getTotalFileCount($configuration);

        $fileInfos = $this->configFileFinder->findFileInfos($configuration->getSources());
        if ($fileInfos === []) {
            $successMessage = sprintf('No YAML configs found in %d files, good job!', $totalFileCount);
            $this->symfonyStyle->success($successMessage);

            return self::SUCCESS;
        }

        foreach ($fileInfos as $fileInfo) {
            $convertedFileContent = $this->configFormatConverter->convert($fileInfo);
            $convertedContent = new ConvertedContent($convertedFileContent, $fileInfo);

            $this->configFileDumper->dumpFile($convertedContent, $configuration);
            $this->removeOriginalYamlFileInfo($configuration, $fileInfo);

            $this->symfonyStyle->newLine();
        }

        // report fail in CI in case of changed files to notify the users about old configs
        if ($configuration->isDryRun()) {
            $successMessage = sprintf('%d file(s) out of %d should be switched to PHP', count($fileInfos), $totalFileCount);
            $this->symfonyStyle->error($successMessage);

            return self::FAILURE;
        }

        $successMessage = sprintf('Processed %d file(s) to "PHP" format, congrats!', count($fileInfos));
        $this->symfonyStyle->success($successMessage);

        return self::SUCCESS;
    }

    private function removeOriginalYamlFileInfo(Configuration $configuration, SplFileInfo $fileInfo): void
    {
        // only dry run, nothing to remove
        if ($configuration->isDryRun()) {
            return;
        }

        FileSystem::delete($fileInfo->getRealPath());
    }

    private function getTotalFileCount(Configuration $configuration): int
    {
        if (count($configuration->getSources()) === 1) {
            $sources = $configuration->getSources();
            if (is_file($sources[0])) {
                return 1;
            }
        }

        return Finder::create()
            ->files()
            ->in($configuration->getSources())
            ->count();
    }
}
