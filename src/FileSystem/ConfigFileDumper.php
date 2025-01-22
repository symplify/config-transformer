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
        $originalFilePathWithoutSuffix = $convertedContent->getOriginalFilePathWithoutSuffix();

        $newFileRealPath = $originalFilePathWithoutSuffix . '.php';

        if ($configuration->isDryRun()) {
            $fileTitle = sprintf(
                'File "%s" would be renamed to "%s"',
                $convertedContent->getOriginalRelativeFilePath(),
                $convertedContent->getNewRelativeFilePath(),
            );
            $this->symfonyStyle->title($fileTitle);
            return;
        }

        // wet run - change the contents
        $fileTitle = sprintf(
            '"%s" was renamed to%s"%s"',
            $convertedContent->getOriginalRelativeFilePath(),
            PHP_EOL,
            $convertedContent->getNewRelativeFilePath(),
        );

        $this->symfonyStyle->writeln($fileTitle);

        FileSystem::write($newFileRealPath, $convertedContent->getConvertedContent());
    }
}
