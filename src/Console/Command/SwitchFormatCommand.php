<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Console\Command;

use ConfigTransformerPrefix202501\Nette\Utils\FileSystem;
use ConfigTransformerPrefix202501\Symfony\Component\Console\Command\Command;
use ConfigTransformerPrefix202501\Symfony\Component\Console\Input\InputArgument;
use ConfigTransformerPrefix202501\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformerPrefix202501\Symfony\Component\Console\Input\InputOption;
use ConfigTransformerPrefix202501\Symfony\Component\Console\Output\OutputInterface;
use ConfigTransformerPrefix202501\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformerPrefix202501\Symfony\Component\Finder\SplFileInfo;
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
    /**
     * @readonly
     * @var \Symplify\ConfigTransformer\Routing\RoutingConfigDetector
     */
    private $routingConfigDetector;
    public function __construct(ConfigurationFactory $configurationFactory, ConfigFileDumper $configFileDumper, ConfigFormatConverter $configFormatConverter, ConfigFileFinder $configFileFinder, SymfonyStyle $symfonyStyle, RoutingConfigDetector $routingConfigDetector)
    {
        $this->configurationFactory = $configurationFactory;
        $this->configFileDumper = $configFileDumper;
        $this->configFormatConverter = $configFormatConverter;
        $this->configFileFinder = $configFileFinder;
        $this->symfonyStyle = $symfonyStyle;
        $this->routingConfigDetector = $routingConfigDetector;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setName('switch-format');
        $this->setAliases(['convert', 'transform']);
        $this->setDescription('Converts YAML configs to PHP format');
        $this->addArgument(Option::SOURCES, InputArgument::IS_ARRAY, 'Path to directory/file with configs', [\getcwd() . '/config']);
        $this->addOption(Option::DRY_RUN, 'n', InputOption::VALUE_NONE, 'Dry run - no removal or config change');
        $this->addOption(Option::SKIP_ROUTES, null, InputOption::VALUE_NONE, 'Skip routing configs, e.g. to handle services first');
    }
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $configuration = $this->configurationFactory->createFromInput($input);
        $fileInfos = $this->configFileFinder->findFileInfos($configuration->getSources());
        if ($configuration->areRoutesIncluded() === \false) {
            // remove routing files if excluded
            $fileInfos = \array_filter($fileInfos, function (SplFileInfo $fileInfo) : bool {
                return !$this->routingConfigDetector->isRoutingFilePath($fileInfo->getRealPath());
            });
        }
        if ($fileInfos === []) {
            $this->symfonyStyle->success('No YAML configs found, good job!');
            return self::SUCCESS;
        }
        foreach ($fileInfos as $fileInfo) {
            $convertedFileContent = $this->configFormatConverter->convert($fileInfo);
            $convertedContent = new ConvertedContent($convertedFileContent, $fileInfo);
            $this->configFileDumper->dumpFile($convertedContent, $configuration);
            if (!$configuration->isDryRun()) {
                FileSystem::delete($fileInfo->getRealPath());
            }
            $this->symfonyStyle->newLine();
        }
        return $this->printResult($configuration, $fileInfos);
    }
    /**
     * @param SplFileInfo[] $fileInfos
     */
    private function printResult(Configuration $configuration, array $fileInfos) : int
    {
        // report fail in CI in case of changed files to notify the users about old configs
        if ($configuration->isDryRun()) {
            $this->symfonyStyle->error(\sprintf('%d file%s would be transformed to PHP format', \count($fileInfos), \count($fileInfos) === 1 ? '' : 's'));
            return self::FAILURE;
        }
        $this->symfonyStyle->success(\sprintf('Transformed %d file%s to PHP format', \count($fileInfos), \count($fileInfos) === 1 ? '' : 's'));
        return self::SUCCESS;
    }
}
