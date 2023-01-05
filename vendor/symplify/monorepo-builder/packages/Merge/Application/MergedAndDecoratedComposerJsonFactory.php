<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\Application;

use ConfigTransformer202301\Symplify\MonorepoBuilder\ComposerJsonManipulator\ValueObject\ComposerJson;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\ComposerJsonMerger;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\Contract\ComposerJsonDecoratorInterface;
use ConfigTransformer202301\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Symplify\MonorepoBuilder\Tests\Merge\Application\MergedAndDecoratedComposerJsonFactoryTest
 */
final class MergedAndDecoratedComposerJsonFactory
{
    /**
     * @var \Symplify\MonorepoBuilder\Merge\ComposerJsonMerger
     */
    private $composerJsonMerger;
    /**
     * @var ComposerJsonDecoratorInterface[]
     */
    private $composerJsonDecorators;
    /**
     * @param ComposerJsonDecoratorInterface[] $composerJsonDecorators
     */
    public function __construct(ComposerJsonMerger $composerJsonMerger, array $composerJsonDecorators)
    {
        $this->composerJsonMerger = $composerJsonMerger;
        $this->composerJsonDecorators = $composerJsonDecorators;
    }
    /**
     * @param SmartFileInfo[] $packageFileInfos
     */
    public function createFromRootConfigAndPackageFileInfos(ComposerJson $mainComposerJson, array $packageFileInfos) : void
    {
        $mergedAndDecoratedComposerJson = $this->mergePackageFileInfosAndDecorate($packageFileInfos);
        $this->composerJsonMerger->mergeJsonToRoot($mainComposerJson, $mergedAndDecoratedComposerJson);
    }
    /**
     * @param SmartFileInfo[] $packageFileInfos
     */
    private function mergePackageFileInfosAndDecorate(array $packageFileInfos) : ComposerJson
    {
        $mergedComposerJson = $this->composerJsonMerger->mergeFileInfos($packageFileInfos);
        foreach ($this->composerJsonDecorators as $composerJsonDecorator) {
            $composerJsonDecorator->decorate($mergedComposerJson);
        }
        return $mergedComposerJson;
    }
}
