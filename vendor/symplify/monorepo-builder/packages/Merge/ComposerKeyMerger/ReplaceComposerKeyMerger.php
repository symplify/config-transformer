<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\ComposerKeyMerger;

use ConfigTransformer202301\Symplify\MonorepoBuilder\ComposerJsonManipulator\ValueObject\ComposerJson;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\Contract\ComposerKeyMergerInterface;
final class ReplaceComposerKeyMerger implements ComposerKeyMergerInterface
{
    public function merge(ComposerJson $mainComposerJson, ComposerJson $newComposerJson) : void
    {
        if ($newComposerJson->getReplace() === []) {
            return;
        }
        $replace = \array_merge($newComposerJson->getReplace(), $mainComposerJson->getReplace());
        $mainComposerJson->setReplace($replace);
    }
}
