<?php

declare (strict_types=1);
namespace ConfigTransformer202111253\Symplify\ConfigTransformer\FileSystem;

use ConfigTransformer202111253\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer202111253\Symplify\ConfigTransformer\ValueObject\Configuration;
use ConfigTransformer202111253\Symplify\ConfigTransformer\ValueObject\ConvertedContent;
use ConfigTransformer202111253\Symplify\SmartFileSystem\SmartFileSystem;
final class ConfigFileDumper
{
    /**
     * @var \Symfony\Component\Console\Style\SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var \Symplify\SmartFileSystem\SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\ConfigTransformer202111253\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \ConfigTransformer202111253\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->smartFileSystem = $smartFileSystem;
    }
    public function dumpFile(\ConfigTransformer202111253\Symplify\ConfigTransformer\ValueObject\ConvertedContent $convertedContent, \ConfigTransformer202111253\Symplify\ConfigTransformer\ValueObject\Configuration $configuration) : void
    {
        $originalFilePathWithoutSuffix = $convertedContent->getOriginalFilePathWithoutSuffix();
        $newFileRealPath = $originalFilePathWithoutSuffix . '.php';
        $relativeFilePath = $this->getRelativePathOfNonExistingFile($newFileRealPath);
        if ($configuration->isDryRun()) {
            $message = \sprintf('File "%s" would be dumped (is --dry-run)', $relativeFilePath);
            $this->symfonyStyle->note($message);
            return;
        }
        $this->smartFileSystem->dumpFile($newFileRealPath, $convertedContent->getConvertedContent());
        $message = \sprintf('File "%s" was dumped', $relativeFilePath);
        $this->symfonyStyle->note($message);
    }
    private function getRelativePathOfNonExistingFile(string $newFilePath) : string
    {
        $relativeFilePath = $this->smartFileSystem->makePathRelative($newFilePath, \getcwd());
        return \rtrim($relativeFilePath, '/');
    }
}
