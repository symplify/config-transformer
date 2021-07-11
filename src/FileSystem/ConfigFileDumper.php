<?php

declare (strict_types=1);
namespace ConfigTransformer202107117\Symplify\ConfigTransformer\FileSystem;

use ConfigTransformer202107117\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer202107117\Symplify\ConfigTransformer\Configuration\Configuration;
use ConfigTransformer202107117\Symplify\ConfigTransformer\ValueObject\ConvertedContent;
use ConfigTransformer202107117\Symplify\SmartFileSystem\SmartFileSystem;
final class ConfigFileDumper
{
    /**
     * @var \Symplify\ConfigTransformer\Configuration\Configuration
     */
    private $configuration;
    /**
     * @var \Symfony\Component\Console\Style\SymfonyStyle
     */
    private $symfonyStyle;
    /**
     * @var \Symplify\SmartFileSystem\SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\ConfigTransformer202107117\Symplify\ConfigTransformer\Configuration\Configuration $configuration, \ConfigTransformer202107117\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \ConfigTransformer202107117\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->configuration = $configuration;
        $this->symfonyStyle = $symfonyStyle;
        $this->smartFileSystem = $smartFileSystem;
    }
    public function dumpFile(\ConfigTransformer202107117\Symplify\ConfigTransformer\ValueObject\ConvertedContent $convertedContent) : void
    {
        $originalFilePathWithoutSuffix = $convertedContent->getOriginalFilePathWithoutSuffix();
        $newFileRealPath = $originalFilePathWithoutSuffix . '.php';
        $relativeFilePath = $this->getRelativePathOfNonExistingFile($newFileRealPath);
        if ($this->configuration->isDryRun()) {
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
