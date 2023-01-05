<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\ComposerKeyMerger;

use ConfigTransformer202301\Symplify\MonorepoBuilder\ComposerJsonManipulator\ValueObject\ComposerJson;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\Arrays\SortedParameterMerger;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\Contract\ComposerKeyMergerInterface;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\Validation\AutoloadPathValidator;
final class AutoloadComposerKeyMerger implements ComposerKeyMergerInterface
{
    /**
     * @var \Symplify\MonorepoBuilder\Merge\Validation\AutoloadPathValidator
     */
    private $autoloadPathValidator;
    /**
     * @var \Symplify\MonorepoBuilder\Merge\Arrays\SortedParameterMerger
     */
    private $sortedParameterMerger;
    public function __construct(AutoloadPathValidator $autoloadPathValidator, SortedParameterMerger $sortedParameterMerger)
    {
        $this->autoloadPathValidator = $autoloadPathValidator;
        $this->sortedParameterMerger = $sortedParameterMerger;
    }
    public function merge(ComposerJson $mainComposerJson, ComposerJson $newComposerJson) : void
    {
        if ($newComposerJson->getAutoload() === []) {
            return;
        }
        $this->autoloadPathValidator->ensureAutoloadPathExists($newComposerJson);
        $autoload = $this->sortedParameterMerger->mergeRecursiveAndSort($mainComposerJson->getAutoload(), $newComposerJson->getAutoload());
        $mainComposerJson->setAutoload($autoload);
    }
}
