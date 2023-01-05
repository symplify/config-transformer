<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\ComposerKeyMerger;

use ConfigTransformer202301\PharIo\Version\InvalidPreReleaseSuffixException;
use ConfigTransformer202301\PharIo\Version\PreReleaseSuffix;
use ConfigTransformer202301\Symplify\MonorepoBuilder\ComposerJsonManipulator\ValueObject\ComposerJson;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\Contract\ComposerKeyMergerInterface;
/**
 * @see \Symplify\MonorepoBuilder\Tests\Merge\ComposerKeyMerger\MinimalStabilityKeyMergerTest
 */
final class MinimalStabilityKeyMerger implements ComposerKeyMergerInterface
{
    public function merge(ComposerJson $mainComposerJson, ComposerJson $newComposerJson) : void
    {
        try {
            $newStability = new PreReleaseSuffix((string) $newComposerJson->getMinimumStability());
        } catch (InvalidPreReleaseSuffixException $exception) {
            return;
        }
        try {
            $mainStability = new PreReleaseSuffix((string) $mainComposerJson->getMinimumStability());
        } catch (InvalidPreReleaseSuffixException $exception) {
            $mainStability = null;
        }
        if (!$mainStability instanceof PreReleaseSuffix || $mainStability->isGreaterThan($newStability)) {
            $mainComposerJson->setMinimumStability($newStability->asString());
        }
    }
}
