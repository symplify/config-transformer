<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Command;

use ConfigTransformer202207\Symfony\Component\Console\Input\InputArgument;
use ConfigTransformer202207\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202207\Symfony\Component\Console\Input\InputOption;
use ConfigTransformer202207\Symfony\Component\Console\Output\OutputInterface;
use Symplify\ConfigTransformer\Configuration\ConfigurationFactory;
use Symplify\ConfigTransformer\Converter\ConvertedContentFactory;
use Symplify\ConfigTransformer\FileSystem\ConfigFileDumper;
use Symplify\ConfigTransformer\ValueObject\Configuration;
use Symplify\ConfigTransformer\ValueObject\Option;
use ConfigTransformer202207\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
use ConfigTransformer202207\Symplify\SmartFileSystem\SmartFileInfo;
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
     * @var \Symplify\ConfigTransformer\Converter\ConvertedContentFactory
     */
    private $convertedContentFactory;
    public function __construct(ConfigurationFactory $configurationFactory, ConfigFileDumper $configFileDumper, ConvertedContentFactory $convertedContentFactory)
    {
        $this->configurationFactory = $configurationFactory;
        $this->configFileDumper = $configFileDumper;
        $this->convertedContentFactory = $convertedContentFactory;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setName('switch-format');
        $this->setDescription('Converts XML/YAML configs to PHP format');
        $this->addArgument(Option::SOURCES, InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Path to directory/file with configs');
        $this->addOption(Option::DRY_RUN, null, InputOption::VALUE_NONE, 'Dry run - no removal or config change');
    }
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $configuration = $this->configurationFactory->createFromInput($input);
        $fileInfos = $this->findFileInfos($configuration);
        foreach ($fileInfos as $fileInfo) {
            $convertedContent = $this->convertedContentFactory->createFromFileInfo($fileInfo);
            $this->configFileDumper->dumpFile($convertedContent, $configuration);
            $this->removeFileInfo($configuration, $fileInfo);
            $this->symfonyStyle->newLine();
        }
        $successMessage = \sprintf('Processed %d file(s) to "PHP" format, congrats!', \count($fileInfos));
        $this->symfonyStyle->success($successMessage);
        return self::SUCCESS;
    }
    /**
     * @return SmartFileInfo[]
     */
    private function findFileInfos(Configuration $configuration) : array
    {
        $suffixes = $configuration->getInputSuffixes();
        $suffixesRegex = '#\\.' . \implode('|', $suffixes) . '$#';
        return $this->smartFinder->find($configuration->getSources(), $suffixesRegex);
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
