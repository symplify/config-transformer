<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Command;

use ConfigTransformerPrefix202302\Nette\Utils\FileSystem;
use ConfigTransformerPrefix202302\Symfony\Component\Console\Command\Command;
use ConfigTransformerPrefix202302\Symfony\Component\Console\Input\InputArgument;
use ConfigTransformerPrefix202302\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformerPrefix202302\Symfony\Component\Console\Input\InputOption;
use ConfigTransformerPrefix202302\Symfony\Component\Console\Output\OutputInterface;
use ConfigTransformerPrefix202302\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformerPrefix202302\Symfony\Component\Finder\Finder;
use Symplify\ConfigTransformer\Configuration\ConfigurationFactory;
use Symplify\ConfigTransformer\Converter\ConfigFormatConverter;
use Symplify\ConfigTransformer\FileSystem\ConfigFileDumper;
use Symplify\ConfigTransformer\Finder\ConfigFileFinder;
use Symplify\ConfigTransformer\ValueObject\Configuration;
use Symplify\ConfigTransformer\ValueObject\ConvertedContent;
use Symplify\ConfigTransformer\ValueObject\Option;
use ConfigTransformerPrefix202302\Symplify\SmartFileSystem\SmartFileInfo;
final class SwitchFormatCommand extends Command
{
    /**
     * @var \Symplify\ConfigTransformer\Configuration\ConfigurationFactory
     */
    private $configurationFactory;
    /**
     * @var \Symplify\ConfigTransformer\FileSystem\ConfigFileDumper
     */
    private $configFileDumper;
    /**
     * @var \Symplify\ConfigTransformer\Converter\ConfigFormatConverter
     */
    private $configFormatConverter;
    /**
     * @var \Symplify\ConfigTransformer\Finder\ConfigFileFinder
     */
    private $configFileFinder;
    /**
     * @var \Symfony\Component\Console\Style\SymfonyStyle
     */
    private $symfonyStyle;
    public function __construct(ConfigurationFactory $configurationFactory, ConfigFileDumper $configFileDumper, ConfigFormatConverter $configFormatConverter, ConfigFileFinder $configFileFinder, SymfonyStyle $symfonyStyle)
    {
        $this->configurationFactory = $configurationFactory;
        $this->configFileDumper = $configFileDumper;
        $this->configFormatConverter = $configFormatConverter;
        $this->configFileFinder = $configFileFinder;
        $this->symfonyStyle = $symfonyStyle;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setName('switch-format');
        $this->setAliases(['convert', 'transform']);
        $this->setDescription('Converts XML/YAML configs to PHP format');
        $this->addArgument(
            Option::SOURCES,
            InputArgument::OPTIONAL | InputArgument::IS_ARRAY,
            'Path to directory/file with configs',
            // 99 % of symfony project has this directory
            [\getcwd() . '/config']
        );
        $this->addOption(Option::DRY_RUN, 'n', InputOption::VALUE_NONE, 'Dry run - no removal or config change');
    }
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $configuration = $this->configurationFactory->createFromInput($input);
        $totalFileCount = $this->getTotalFileCount($configuration);
        $fileInfos = $this->configFileFinder->findFileInfos($configuration);
        if ($fileInfos === []) {
            $successMessage = \sprintf('No YAML/XML configs found in %d files, good job!', $totalFileCount);
            $this->symfonyStyle->success($successMessage);
            return self::SUCCESS;
        }
        foreach ($fileInfos as $fileInfo) {
            $convertedFileContent = $this->configFormatConverter->convert($fileInfo);
            $convertedContent = new ConvertedContent($convertedFileContent, $fileInfo);
            $this->configFileDumper->dumpFile($convertedContent, $configuration);
            $this->removeFileInfo($configuration, $fileInfo);
            $this->symfonyStyle->newLine();
        }
        // report fail in CI in case of changed files to notify the users about old configs
        if ($configuration->isDryRun()) {
            $successMessage = \sprintf('%d file(s) out of %d should be switched to PHP', \count($fileInfos), $totalFileCount);
            $this->symfonyStyle->error($successMessage);
            return self::FAILURE;
        }
        $successMessage = \sprintf('Processed %d file(s) to "PHP" format, congrats!', \count($fileInfos));
        $this->symfonyStyle->success($successMessage);
        return self::SUCCESS;
    }
    private function removeFileInfo(Configuration $configuration, SmartFileInfo $fileInfo) : void
    {
        // only dry run, nothing to remove
        if ($configuration->isDryRun()) {
            return;
        }
        FileSystem::delete($fileInfo->getRealPath());
    }
    private function getTotalFileCount(Configuration $configuration) : int
    {
        if (\count($configuration->getSources()) === 1) {
            $sources = $configuration->getSources();
            if (\is_file($sources[0])) {
                return 1;
            }
        }
        return Finder::create()->files()->in($configuration->getSources())->count();
    }
}
