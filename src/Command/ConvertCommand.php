<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\Command;

use Migrify\ConfigTransformer\Configuration\Configuration;
use Migrify\ConfigTransformer\Converter\ConfigTransformer;
use Migrify\ConfigTransformer\Finder\ConfigFileFinder;
use Migrify\ConfigTransformer\ValueObject\Option;
use Nette\Utils\FileSystem;
use Nette\Utils\Strings;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\PackageBuilder\Console\Command\CommandNaming;
use Symplify\PackageBuilder\Console\ShellCode;
use Symplify\SmartFileSystem\SmartFileInfo;

final class ConvertCommand extends Command
{
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;

    /**
     * @var ConfigFileFinder
     */
    private $configFileFinder;

    /**
     * @var ConfigTransformer
     */
    private $configFormatConverter;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(
        SymfonyStyle $symfonyStyle,
        ConfigFileFinder $configFileFinder,
        ConfigTransformer $configFormatConverter,
        Configuration $configuration
    ) {
        parent::__construct();

        $this->symfonyStyle = $symfonyStyle;
        $this->configFileFinder = $configFileFinder;
        $this->configFormatConverter = $configFormatConverter;
        $this->configuration = $configuration;
    }

    protected function configure(): void
    {
        $this->setName(CommandNaming::classToName(self::class));
        $this->setDescription('Converts all XML files to provided format');

        $this->addArgument(Option::SOURCE, InputArgument::REQUIRED, 'Path to directory with configs');
        $this->addOption(Option::OUTPUT_FORMAT, null, InputOption::VALUE_REQUIRED, 'Config format to output');
        $this->addOption(Option::DELETE, null, InputOption::VALUE_NONE, 'Delete original files');
        $this->addOption(
            Option::TARGET_SYMFONY_VERSION,
            null,
            InputOption::VALUE_REQUIRED,
            'Symfony version to migrate config to'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->configuration->populateFromInput($input);

        $fileInfos = $this->configFileFinder->findInDirectory($this->configuration->getSource());

        $convertedFileInfos = [];

        foreach ($fileInfos as $fileInfo) {
            $convertedContent = $this->configFormatConverter->convert(
                $fileInfo,
                $this->configuration->getOutputFormat()
            );

            // dump the file
            $newFileInfo = $this->dumpFile($fileInfo, $convertedContent);
            $convertedFileInfos[] = $newFileInfo;
        }

        $this->deleteOldFiles($fileInfos);

        $successMessage = sprintf(
            '%d files were converted to YAML, while keeping original XML files.',
            count($convertedFileInfos)
        );
        $this->symfonyStyle->success($successMessage);

        return ShellCode::SUCCESS;
    }

    /**
     * @param SmartFileInfo[] $fileInfos
     */
    private function deleteOldFiles(array $fileInfos): void
    {
        if (count($fileInfos) === 0) {
            return;
        }

        if (! $this->configuration->shouldDeleteOldFiles()) {
            return;
        }

        foreach ($fileInfos as $fileInfo) {
            FileSystem::delete($fileInfo->getRealPath());
        }

        $deletedFilesMessage = sprintf('Deleted %d original files', count($fileInfos));
        $this->symfonyStyle->warning($deletedFilesMessage);
    }

    private function dumpFile(SmartFileInfo $fileInfo, string $convertedContent): SmartFileInfo
    {
        $fileRealPathWithoutSuffix = Strings::replace($fileInfo->getRealPath(), '#\.[^.]+$#');
        $newFilePath = $fileRealPathWithoutSuffix . '.' . $this->configuration->getOutputFormat();
        FileSystem::write($newFilePath, $convertedContent);

        $newFileInfo = new SmartFileInfo($newFilePath);
        $message = sprintf('File "%s" was dumped', $newFileInfo->getRelativeFilePathFromCwd());
        $this->symfonyStyle->writeln($message);

        return $newFileInfo;
    }
}
