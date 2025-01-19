<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\FileSystem;

use ConfigTransformerPrefix202501\Nette\Utils\FileSystem;
use ConfigTransformerPrefix202501\Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\ConfigTransformer\Console\ConsoleDiffer;
use Symplify\ConfigTransformer\ValueObject\Configuration;
use Symplify\ConfigTransformer\ValueObject\ConvertedContent;
final class ConfigFileDumper
{
    /**
     * @readonly
     * @var \Symfony\Component\Console\Style\SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @readonly
     * @var \Symplify\ConfigTransformer\Console\ConsoleDiffer
     */
    private $consoleDiffer;
    public function __construct(SymfonyStyle $symfonyStyle, ConsoleDiffer $consoleDiffer)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->consoleDiffer = $consoleDiffer;
    }
    public function dumpFile(ConvertedContent $convertedContent, Configuration $configuration) : void
    {
        $originalFilePathWithoutSuffix = $convertedContent->getOriginalFilePathWithoutSuffix();
        $newFileRealPath = $originalFilePathWithoutSuffix . '.php';
        if ($configuration->isDryRun()) {
            $fileTitle = \sprintf('File "%s" would be renamed to "%s"', $convertedContent->getOriginalRelativeFilePath(), $convertedContent->getNewRelativeFilePath());
            $this->symfonyStyle->title($fileTitle);
            $consoleDiff = $this->consoleDiffer->diff($convertedContent->getOriginalContent(), $convertedContent->getConvertedContent());
            $this->symfonyStyle->writeln($consoleDiff);
            return;
        }
        // wet run - change the contents
        $fileTitle = \sprintf('"%s" was renamed to%s"%s"', $convertedContent->getOriginalRelativeFilePath(), \PHP_EOL, $convertedContent->getNewRelativeFilePath());
        $this->symfonyStyle->title($fileTitle);
        FileSystem::write($newFileRealPath, $convertedContent->getConvertedContent());
    }
}
