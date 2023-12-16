<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Console\Command;

use ConfigTransformerPrefix202312\Nette\Utils\FileSystem;
use ConfigTransformerPrefix202312\Symfony\Component\Console\Command\Command;
use ConfigTransformerPrefix202312\Symfony\Component\Console\Input\InputArgument;
use ConfigTransformerPrefix202312\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformerPrefix202312\Symfony\Component\Console\Input\InputOption;
use ConfigTransformerPrefix202312\Symfony\Component\Console\Output\OutputInterface;
use ConfigTransformerPrefix202312\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformerPrefix202312\Symfony\Component\Finder\SplFileInfo;
use Symplify\ConfigTransformer\Configuration\ConfigurationFactory;
use Symplify\ConfigTransformer\Converter\ConfigFormatConverter;
use Symplify\ConfigTransformer\FileSystem\ConfigFileDumper;
use Symplify\ConfigTransformer\Finder\ConfigFileFinder;
use Symplify\ConfigTransformer\ValueObject\Configuration;
use Symplify\ConfigTransformer\ValueObject\ConvertedContent;
use Symplify\ConfigTransformer\ValueObject\Option;
final class SwitchFormatCommand extends Command
{
    /**
     * @readonly
     * @var \Symplify\ConfigTransformer\Configuration\ConfigurationFactory
     */
    private $configurationFactory;
    /**
     * @readonly
     * @var \Symplify\ConfigTransformer\FileSystem\ConfigFileDumper
     */
    private $configFileDumper;
    /**
     * @readonly
     * @var \Symplify\ConfigTransformer\Converter\ConfigFormatConverter
     */
    private $configFormatConverter;
    /**
     * @readonly
     * @var \Symplify\ConfigTransformer\Finder\ConfigFileFinder
     */
    private $configFileFinder;
    /**
     * @readonly
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
        $this->setDescription('Converts YAML configs to PHP format');
        $this->addArgument(Option::SOURCES, InputArgument::IS_ARRAY, 'Path to directory/file with configs');
        $this->addOption(Option::DRY_RUN, null, InputOption::VALUE_NONE, 'Dry run - no removal or config change');
    }
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $configuration = $this->configurationFactory->createFromInput($input);
        $fileInfos = $this->configFileFinder->findFileInfos($configuration->getSources());
        if ($fileInfos === []) {
            $this->symfonyStyle->success('No YAML configs found, good job!');
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
            $successMessage = \sprintf('%d file(s) should be switched to PHP', \count($fileInfos));
            $this->symfonyStyle->error($successMessage);
            return self::FAILURE;
        }
        $successMessage = \sprintf('Processed %d file(s) to "PHP" format, congrats!', \count($fileInfos));
        $this->symfonyStyle->success($successMessage);
        return self::SUCCESS;
    }
    private function removeOriginalYamlFileInfo(Configuration $configuration, SplFileInfo $fileInfo) : void
    {
        // only dry run, nothing to remove
        if ($configuration->isDryRun()) {
            return;
        }
        FileSystem::delete($fileInfo->getRealPath());
    }
}
