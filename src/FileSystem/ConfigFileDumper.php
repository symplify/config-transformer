<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\FileSystem;

use ConfigTransformerPrefix202507\Nette\Utils\FileSystem;
use ConfigTransformerPrefix202507\Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\ConfigTransformer\ValueObject\Configuration;
use Symplify\ConfigTransformer\ValueObject\ConvertedContent;
final class ConfigFileDumper
{
    /**
     * @readonly
     * @var \Symfony\Component\Console\Style\SymfonyStyle
     */
    private $symfonyStyle;
    public function __construct(SymfonyStyle $symfonyStyle)
    {
        $this->symfonyStyle = $symfonyStyle;
    }
    public function dumpFile(ConvertedContent $convertedContent, Configuration $configuration) : void
    {
        $this->symfonyStyle->writeln(\sprintf('Converting "<fg=yellow>%s</>"%sto"<fg=green>%s</>"%s', $convertedContent->getOriginalRelativeFilePath(), \PHP_EOL, $convertedContent->getNewRelativeFilePath(), $configuration->isDryRun() ? ' (dry run)' : ''));
        $this->symfonyStyle->newLine();
        $originalFilePathWithoutSuffix = $convertedContent->getOriginalFilePathWithoutSuffix();
        $newFileRealPath = $originalFilePathWithoutSuffix . '.php';
        FileSystem::write($newFileRealPath, $convertedContent->getConvertedContent());
    }
}
