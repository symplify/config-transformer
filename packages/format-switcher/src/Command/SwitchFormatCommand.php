<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\FormatSwitcher\Command;

use Migrify\ConfigTransformer\FormatSwitcher\Configuration\Configuration;
use Migrify\ConfigTransformer\FormatSwitcher\Converter\ConfigFormatConverter;
use Migrify\ConfigTransformer\FormatSwitcher\Finder\ConfigFileFinder;
use Migrify\ConfigTransformer\FormatSwitcher\ValueObject\Option;
use Nette\Utils\Strings;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symplify\PackageBuilder\Console\Command\CommandNaming;
use Symplify\PackageBuilder\Console\ShellCode;
use Symplify\SmartFileSystem\SmartFileInfo;

final class SwitchFormatCommand extends Command
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
     * @var ConfigFormatConverter
     */
    private $configFormatConverter;

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(
        SymfonyStyle $symfonyStyle,
        ConfigFileFinder $configFileFinder,
        ConfigFormatConverter $configFormatConverter,
        Configuration $configuration,
        Filesystem $filesystem
    ) {
        parent::__construct();

        $this->symfonyStyle = $symfonyStyle;
        $this->configFileFinder = $configFileFinder;
        $this->configFormatConverter = $configFormatConverter;
        $this->configuration = $configuration;
        $this->filesystem = $filesystem;
    }

    protected function configure(): void
    {
        $this->setName(CommandNaming::classToName(self::class));
        $this->setDescription('Converts all XML files to provided format');

        $this->addArgument(
            Option::SOURCE,
            InputArgument::REQUIRED | InputArgument::IS_ARRAY,
            'Path to directory with configs'
        );

        $this->addOption(Option::INPUT_FORMAT, null, InputOption::VALUE_REQUIRED, 'Config format to input');
        $this->addOption(Option::OUTPUT_FORMAT, null, InputOption::VALUE_REQUIRED, 'Config format to output');

        $this->addOption(
            Option::TARGET_SYMFONY_VERSION,
            null,
            InputOption::VALUE_REQUIRED,
            'Symfony version to migrate config to'
        );

        $this->addOption(Option::DRY_RUN, null, InputOption::VALUE_NONE, 'Dry run - no removal or config change');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->configuration->populateFromInput($input);
        $fileInfos = $this->configFileFinder->findInSourceBySuffix(
            $this->configuration->getSource(),
            $this->configuration->getInputFormat()
        );

        $convertedFileInfos = [];
        foreach ($fileInfos as $fileInfo) {
            $convertedContent = $this->configFormatConverter->convert(
                $fileInfo,
                $this->configuration->getOutputFormat()
            );

            $newFileInfo = $this->dumpFile($fileInfo, $convertedContent);
            if ($newFileInfo === null) {
                continue;
            }

            $convertedFileInfos[] = $newFileInfo;
        }

        $this->deleteOldFiles($fileInfos);

        $successMessage = sprintf(
            'Processed %d files from "%s" to "%s" format',
            count($fileInfos),
            $this->configuration->getInputFormat(),
            $this->configuration->getOutputFormat()
        );
        $this->symfonyStyle->success($successMessage);

        return ShellCode::SUCCESS;
    }

    /**
     * @param SmartFileInfo[] $fileInfos
     */
    private function deleteOldFiles(array $fileInfos): void
    {
        if ($this->configuration->isDryRun()) {
            return;
        }

        if (count($fileInfos) === 0) {
            return;
        }

        $this->filesystem->remove($fileInfos);

        $deletedFilesMessage = sprintf('Deleted %d original files', count($fileInfos));
        $this->symfonyStyle->warning($deletedFilesMessage);
    }

    private function dumpFile(SmartFileInfo $fileInfo, string $convertedContent): ?SmartFileInfo
    {
        $fileRealPathWithoutSuffix = Strings::replace($fileInfo->getRealPath(), '#\.[^.]+$#');
        $newFilePath = $fileRealPathWithoutSuffix . '.' . $this->configuration->getOutputFormat();

        $relativeFilePath = $this->getRelativePathOfNonExistingFile($newFilePath);

        if ($this->configuration->isDryRun()) {
            $message = sprintf('File "%s" would be dumped (is --dry-run)', $relativeFilePath);
            $this->symfonyStyle->note($message);
            return null;
        }

        $this->filesystem->dumpFile($newFilePath, $convertedContent);

        $message = sprintf('File "%s" was dumped', $relativeFilePath);
        $this->symfonyStyle->writeln($message);

        return new SmartFileInfo($relativeFilePath);
    }

    private function getRelativePathOfNonExistingFile(string $newFilePath): string
    {
        $relativeFilePath = $this->filesystem->makePathRelative($newFilePath, getcwd());
        return rtrim($relativeFilePath, '/');
    }
}
