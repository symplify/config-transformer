<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Merge\Configuration;

use ConfigTransformer202301\Symplify\MonorepoBuilder\ComposerJsonManipulator\ComposerJsonFactory;
use ConfigTransformer202301\Symplify\MonorepoBuilder\ComposerJsonManipulator\ValueObject\ComposerJson;
use ConfigTransformer202301\Symplify\MonorepoBuilder\ValueObject\Option;
use ConfigTransformer202301\Symplify\PackageBuilder\Parameter\ParameterProvider;
final class ModifyingComposerJsonProvider
{
    /**
     * @var \Symplify\MonorepoBuilder\ComposerJsonManipulator\ComposerJsonFactory
     */
    private $composerJsonFactory;
    /**
     * @var \Symplify\PackageBuilder\Parameter\ParameterProvider
     */
    private $parameterProvider;
    public function __construct(ComposerJsonFactory $composerJsonFactory, ParameterProvider $parameterProvider)
    {
        $this->composerJsonFactory = $composerJsonFactory;
        $this->parameterProvider = $parameterProvider;
    }
    public function getRemovingComposerJson() : ?ComposerJson
    {
        $dataToRemove = $this->parameterProvider->provideArrayParameter(Option::DATA_TO_REMOVE);
        if ($dataToRemove === []) {
            return null;
        }
        return $this->composerJsonFactory->createFromArray($dataToRemove);
    }
    public function getAppendingComposerJson() : ?ComposerJson
    {
        $dataToAppend = $this->parameterProvider->provideArrayParameter(Option::DATA_TO_APPEND);
        if ($dataToAppend === []) {
            return null;
        }
        return $this->composerJsonFactory->createFromArray($dataToAppend);
    }
}
