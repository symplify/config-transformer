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
        $this->symfonyStyle->writeln(sprintf(
            'Converting "<fg=yellow>%s</>"%sto "<fg=green>%s</>"%s',
            $convertedContent->getOriginalRelativeFilePath(),
            PHP_EOL,
            $convertedContent->getNewRelativeFilePath(),
            $configuration->isDryRun() ? ' (dry run)' : ''
        ));
        $this->symfonyStyle->newLine();

        // do not modify files
        if ($configuration->isDryRun()) {
            return;
        }

        $originalFilePathWithoutSuffix = $convertedContent->getOriginalFilePathWithoutSuffix();
        $newFileRealPath = $originalFilePathWithoutSuffix . '.php';

        FileSystem::write($newFileRealPath, $convertedContent->getConvertedContent());
    }
}
