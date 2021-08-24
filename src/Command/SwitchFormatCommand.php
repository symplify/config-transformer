<?php

declare (strict_types=1);
namespace ConfigTransformer2021082410\Symplify\ConfigTransformer\Command;

use ConfigTransformer2021082410\Symfony\Component\Console\Input\InputArgument;
use ConfigTransformer2021082410\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer2021082410\Symfony\Component\Console\Input\InputOption;
use ConfigTransformer2021082410\Symfony\Component\Console\Output\OutputInterface;
use ConfigTransformer2021082410\Symplify\ConfigTransformer\Configuration\Configuration;
use ConfigTransformer2021082410\Symplify\ConfigTransformer\Converter\ConvertedContentFactory;
use ConfigTransformer2021082410\Symplify\ConfigTransformer\FileSystem\ConfigFileDumper;
use ConfigTransformer2021082410\Symplify\ConfigTransformer\ValueObject\Option;
use ConfigTransformer2021082410\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
final class SwitchFormatCommand extends \ConfigTransformer2021082410\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand
{
    /**
     * @var \Symplify\ConfigTransformer\Configuration\Configuration
     */
    private $configuration;
    /**
     * @var \Symplify\ConfigTransformer\FileSystem\ConfigFileDumper
     */
    private $configFileDumper;
    /**
     * @var \Symplify\ConfigTransformer\Converter\ConvertedContentFactory
     */
    private $convertedContentFactory;
    public function __construct(\ConfigTransformer2021082410\Symplify\ConfigTransformer\Configuration\Configuration $configuration, \ConfigTransformer2021082410\Symplify\ConfigTransformer\FileSystem\ConfigFileDumper $configFileDumper, \ConfigTransformer2021082410\Symplify\ConfigTransformer\Converter\ConvertedContentFactory $convertedContentFactory)
    {
        $this->configuration = $configuration;
        $this->configFileDumper = $configFileDumper;
        $this->convertedContentFactory = $convertedContentFactory;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setDescription('Converts XML/YAML configs to PHP format');
        $this->addArgument(\ConfigTransformer2021082410\Symplify\ConfigTransformer\ValueObject\Option::SOURCES, \ConfigTransformer2021082410\Symfony\Component\Console\Input\InputArgument::REQUIRED | \ConfigTransformer2021082410\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Path to directory with configs');
        $this->addOption(\ConfigTransformer2021082410\Symplify\ConfigTransformer\ValueObject\Option::TARGET_SYMFONY_VERSION, 's', \ConfigTransformer2021082410\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Symfony version to migrate config to', '3.2');
        $this->addOption(\ConfigTransformer2021082410\Symplify\ConfigTransformer\ValueObject\Option::DRY_RUN, null, \ConfigTransformer2021082410\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Dry run - no removal or config change');
    }
    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    protected function execute($input, $output) : int
    {
        $this->configuration->populateFromInput($input);
        $suffixes = $this->configuration->getInputSuffixes();
        $suffixesRegex = '#\\.' . \implode('|', $suffixes) . '$#';
        $fileInfos = $this->smartFinder->find($this->configuration->getSource(), $suffixesRegex);
        $convertedContents = $this->convertedContentFactory->createFromFileInfos($fileInfos);
        foreach ($convertedContents as $convertedContent) {
            $this->configFileDumper->dumpFile($convertedContent);
        }
        if (!$this->configuration->isDryRun()) {
            $this->smartFileSystem->remove($fileInfos);
        }
        $successMessage = \sprintf('Processed %d file(s) to "PHP" format', \count($fileInfos));
        $this->symfonyStyle->success($successMessage);
        return self::SUCCESS;
    }
}
