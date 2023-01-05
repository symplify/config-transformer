<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use ConfigTransformer202301\Nette\Utils\DateTime;
use ConfigTransformer202301\Nette\Utils\Strings;
use ConfigTransformer202301\PharIo\Version\Version;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Release\Contract\ReleaseWorker\ReleaseWorkerInterface;
use ConfigTransformer202301\Symplify\SmartFileSystem\SmartFileSystem;
final class AddTagToChangelogReleaseWorker implements ReleaseWorkerInterface
{
    /**
     * @var string
     * @see https://regex101.com/r/5KOvEb/1
     */
    private const UNRELEASED_HEADLINE_REGEX = '#\\#\\# Unreleased#';
    /**
     * @var \Symplify\SmartFileSystem\SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(SmartFileSystem $smartFileSystem)
    {
        $this->smartFileSystem = $smartFileSystem;
    }
    public function work(Version $version) : void
    {
        $changelogFilePath = \getcwd() . '/CHANGELOG.md';
        if (!\file_exists($changelogFilePath)) {
            return;
        }
        $newHeadline = $this->createNewHeadline($version);
        $changelogFileContent = $this->smartFileSystem->readFile($changelogFilePath);
        $changelogFileContent = Strings::replace($changelogFileContent, self::UNRELEASED_HEADLINE_REGEX, '## ' . $newHeadline);
        $this->smartFileSystem->dumpFile($changelogFilePath, $changelogFileContent);
    }
    public function getDescription(Version $version) : string
    {
        $newHeadline = $this->createNewHeadline($version);
        return \sprintf('Change "Unreleased" in `CHANGELOG.md` to "%s"', $newHeadline);
    }
    private function createNewHeadline(Version $version) : string
    {
        $dateTime = new DateTime();
        return $version->getVersionString() . ' - ' . $dateTime->format('Y-m-d');
    }
}
