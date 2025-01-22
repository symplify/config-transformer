<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\FileSystem;

use Nette\Utils\FileSystem;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\ConfigTransformer\ValueObject\Configuration;
use Symplify\ConfigTransformer\ValueObject\ConvertedContent;

final class ConfigFileDumper
{
    public function __construct(
        private readonly SymfonyStyle $symfonyStyle,
    ) {
    }

    public function dumpFile(ConvertedContent $convertedContent, Configuration $configuration): void
    {
        if ($configuration->isDryRun()) {
            // report only
            $this->symfonyStyle->writeln($convertedContent->getOriginalRelativeFilePath() . ' would be removed');
            $this->symfonyStyle->writeln($convertedContent->getNewRelativeFilePath() . ' would be added');
            $this->symfonyStyle->newLine();
            return;
        }

        $this->symfonyStyle->writeln($convertedContent->getOriginalRelativeFilePath() . ' removed');
        $this->symfonyStyle->writeln($convertedContent->getNewRelativeFilePath() . ' added');
        $this->symfonyStyle->newLine();

        $originalFilePathWithoutSuffix = $convertedContent->getOriginalFilePathWithoutSuffix();
        $newFileRealPath = $originalFilePathWithoutSuffix . '.php';

        FileSystem::write($newFileRealPath, $convertedContent->getConvertedContent());
    }
}
