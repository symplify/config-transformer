<?php

declare (strict_types=1);
namespace ConfigTransformer202205256\Symplify\ConfigTransformer\Command;

use ConfigTransformer202205256\Symfony\Component\Console\Input\InputArgument;
use ConfigTransformer202205256\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202205256\Symfony\Component\Console\Input\InputOption;
use ConfigTransformer202205256\Symfony\Component\Console\Output\OutputInterface;
use ConfigTransformer202205256\Symplify\ConfigTransformer\Configuration\ConfigurationFactory;
use ConfigTransformer202205256\Symplify\ConfigTransformer\Converter\ConvertedContentFactory;
use ConfigTransformer202205256\Symplify\ConfigTransformer\FileSystem\ConfigFileDumper;
use ConfigTransformer202205256\Symplify\ConfigTransformer\ValueObject\Configuration;
use ConfigTransformer202205256\Symplify\ConfigTransformer\ValueObject\Option;
use ConfigTransformer202205256\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
use ConfigTransformer202205256\Symplify\PackageBuilder\Console\Command\CommandNaming;
use ConfigTransformer202205256\Symplify\SmartFileSystem\SmartFileInfo;
final class SwitchFormatCommand extends \ConfigTransformer202205256\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand
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
     * @var \Symplify\ConfigTransformer\Converter\ConvertedContentFactory
     */
    private $convertedContentFactory;
    public function __construct(\ConfigTransformer202205256\Symplify\ConfigTransformer\Configuration\ConfigurationFactory $configurationFactory, \ConfigTransformer202205256\Symplify\ConfigTransformer\FileSystem\ConfigFileDumper $configFileDumper, \ConfigTransformer202205256\Symplify\ConfigTransformer\Converter\ConvertedContentFactory $convertedContentFactory)
    {
        $this->configurationFactory = $configurationFactory;
        $this->configFileDumper = $configFileDumper;
        $this->convertedContentFactory = $convertedContentFactory;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setName(\ConfigTransformer202205256\Symplify\PackageBuilder\Console\Command\CommandNaming::classToName(self::class));
        $this->setDescription('Converts XML/YAML configs to PHP format');
        $this->addArgument(\ConfigTransformer202205256\Symplify\ConfigTransformer\ValueObject\Option::SOURCES, \ConfigTransformer202205256\Symfony\Component\Console\Input\InputArgument::REQUIRED | \ConfigTransformer202205256\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Path to directory with configs');
        $this->addOption(\ConfigTransformer202205256\Symplify\ConfigTransformer\ValueObject\Option::DRY_RUN, null, \ConfigTransformer202205256\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Dry run - no removal or config change');
    }
    protected function execute(\ConfigTransformer202205256\Symfony\Component\Console\Input\InputInterface $input, \ConfigTransformer202205256\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $configuration = $this->configurationFactory->createFromInput($input);
        $suffixes = $configuration->getInputSuffixes();
        $suffixesRegex = '#\\.' . \implode('|', $suffixes) . '$#';
        $fileInfos = $this->smartFinder->find($configuration->getSources(), $suffixesRegex);
        $convertedContents = $this->convertedContentFactory->createFromFileInfos($fileInfos);
        foreach ($convertedContents as $convertedContent) {
            $this->configFileDumper->dumpFile($convertedContent, $configuration);
        }
        $this->removeFileInfos($configuration, $fileInfos);
        $successMessage = \sprintf('Processed %d file(s) to "PHP" format', \count($fileInfos));
        $this->symfonyStyle->success($successMessage);
        return self::SUCCESS;
    }
    /**
     * @param SmartFileInfo[] $fileInfos
     */
    private function removeFileInfos(\ConfigTransformer202205256\Symplify\ConfigTransformer\ValueObject\Configuration $configuration, array $fileInfos) : void
    {
        if (!$configuration->isDryRun()) {
            $this->smartFileSystem->remove($fileInfos);
            foreach ($fileInfos as $fileInfo) {
                $message = \sprintf('File "%s" was be removed', $fileInfo->getRelativeFilePath());
                $this->symfonyStyle->note($message);
            }
        } else {
            foreach ($fileInfos as $fileInfo) {
                $message = \sprintf('[dry-run] File "%s" would be removed', $fileInfo->getRelativeFilePath());
                $this->symfonyStyle->note($message);
            }
        }
    }
}
