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
use Symfony\Component\Finder\SplFileInfo;
use Symplify\ConfigTransformer\Configuration\ConfigurationFactory;
use Symplify\ConfigTransformer\Converter\ConfigFormatConverter;
use Symplify\ConfigTransformer\FileSystem\ConfigFileDumper;
use Symplify\ConfigTransformer\Finder\ConfigFileFinder;
use Symplify\ConfigTransformer\Routing\RoutingConfigDetector;
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
        private readonly RoutingConfigDetector $routingConfigDetector
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
            'Path to directory/file with configs',
        );

        $this->addOption(Option::DRY_RUN, 'n', InputOption::VALUE_NONE, 'Dry run - no removal or config change');
        $this->addOption(Option::SKIP_ROUTES, null, InputOption::VALUE_NONE, 'Skip routing configs, e.g. to handle services first');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $configuration = $this->configurationFactory->createFromInput($input);

        $fileInfos = $this->configFileFinder->findFileInfos($configuration->getSources());

        if ($configuration->areRoutesIncluded() === false) {
            // remove routing files if excluded
            $fileInfos = array_filter($fileInfos, fn (SplFileInfo $fileInfo): bool => ! $this->routingConfigDetector->isRoutingFilePath($fileInfo->getRealPath()));
        }

        if ($fileInfos === []) {
            $this->symfonyStyle->success('No YAML configs found, good job!');

            return self::SUCCESS;
        }

        foreach ($fileInfos as $fileInfo) {
            $convertedFileContent = $this->configFormatConverter->convert($fileInfo);
            $convertedContent = new ConvertedContent($convertedFileContent, $fileInfo);

            $this->configFileDumper->dumpFile($convertedContent, $configuration);

            if (! $configuration->isDryRun()) {
                FileSystem::delete($fileInfo->getRealPath());
            }
        }

        return $this->printResult($configuration, $fileInfos);
    }

    /**
     * @param SplFileInfo[] $fileInfos
     */
    private function printResult(Configuration $configuration, array $fileInfos): int
    {
        // report fail in CI in case of changed files to notify the users about old configs
        if ($configuration->isDryRun()) {
            $this->symfonyStyle->warning(sprintf(
                '%d file%s would be transformed to PHP format',
                count($fileInfos),
                count($fileInfos) === 1 ? '' : 's'
            ));

            return self::FAILURE;
        }

        $this->symfonyStyle->success(sprintf(
            'Transformed %d file%s to PHP format',
            count($fileInfos),
            count($fileInfos) === 1 ? '' : 's'
        ));

        return self::SUCCESS;
    }
}
