<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Command;

use ConfigTransformer202208\Symfony\Component\Console\Input\InputArgument;
use ConfigTransformer202208\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202208\Symfony\Component\Console\Input\InputOption;
use ConfigTransformer202208\Symfony\Component\Console\Output\OutputInterface;
use Symplify\ConfigTransformer\Configuration\ConfigurationFactory;
use Symplify\ConfigTransformer\Converter\ConfigFormatConverter;
use Symplify\ConfigTransformer\FileSystem\ConfigFileDumper;
use Symplify\ConfigTransformer\Finder\ConfigFileFinder;
use Symplify\ConfigTransformer\ValueObject\Configuration;
use Symplify\ConfigTransformer\ValueObject\ConvertedContent;
use Symplify\ConfigTransformer\ValueObject\Option;
use ConfigTransformer202208\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
use ConfigTransformer202208\Symplify\SmartFileSystem\SmartFileInfo;
final class SwitchFormatCommand extends AbstractSymplifyCommand
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
    public function __construct(ConfigurationFactory $configurationFactory, ConfigFileDumper $configFileDumper, ConfigFormatConverter $configFormatConverter, ConfigFileFinder $configFileFinder)
    {
        $this->configurationFactory = $configurationFactory;
        $this->configFileDumper = $configFileDumper;
        $this->configFormatConverter = $configFormatConverter;
        $this->configFileFinder = $configFileFinder;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setName('switch-format');
        $this->setDescription('Converts XML/YAML configs to PHP format');
        $this->addArgument(Option::SOURCES, InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Path to directory/file with configs');
        $this->addOption(Option::DRY_RUN, 'n', InputOption::VALUE_NONE, 'Dry run - no removal or config change');
    }
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $configuration = $this->configurationFactory->createFromInput($input);
        $fileInfos = $this->configFileFinder->findFileInfos($configuration);
        foreach ($fileInfos as $fileInfo) {
            $convertedFileContent = $this->configFormatConverter->convert($fileInfo);
            $convertedContent = new ConvertedContent($convertedFileContent, $fileInfo);
            $this->configFileDumper->dumpFile($convertedContent, $configuration);
            $this->removeFileInfo($configuration, $fileInfo);
            $this->symfonyStyle->newLine();
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
        $this->smartFileSystem->remove($fileInfo->getRealPath());
    }
}
