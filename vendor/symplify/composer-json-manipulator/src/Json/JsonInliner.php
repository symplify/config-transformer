<?php

declare (strict_types=1);
namespace ConfigTransformer202204179\Symplify\ComposerJsonManipulator\Json;

use ConfigTransformer202204179\Nette\Utils\Strings;
use ConfigTransformer202204179\Symplify\ComposerJsonManipulator\ValueObject\Option;
use ConfigTransformer202204179\Symplify\PackageBuilder\Parameter\ParameterProvider;
final class JsonInliner
{
    /**
     * @var string
     * @see https://regex101.com/r/jhWo9g/1
     */
    private const SPACE_REGEX = '#\\s+#';
    /**
     * @var \Symplify\PackageBuilder\Parameter\ParameterProvider
     */
    private $parameterProvider;
    public function __construct(\ConfigTransformer202204179\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $this->parameterProvider = $parameterProvider;
    }
    public function inlineSections(string $jsonContent) : string
    {
        if (!$this->parameterProvider->hasParameter(\ConfigTransformer202204179\Symplify\ComposerJsonManipulator\ValueObject\Option::INLINE_SECTIONS)) {
            return $jsonContent;
        }
        $inlineSections = $this->parameterProvider->provideArrayParameter(\ConfigTransformer202204179\Symplify\ComposerJsonManipulator\ValueObject\Option::INLINE_SECTIONS);
        foreach ($inlineSections as $inlineSection) {
            $pattern = '#("' . \preg_quote($inlineSection, '#') . '": )\\[(.*?)\\](,)#ms';
            $jsonContent = \ConfigTransformer202204179\Nette\Utils\Strings::replace($jsonContent, $pattern, function (array $match) : string {
                $inlined = \ConfigTransformer202204179\Nette\Utils\Strings::replace($match[2], self::SPACE_REGEX, ' ');
                $inlined = \trim($inlined);
                $inlined = '[' . $inlined . ']';
                return $match[1] . $inlined . $match[3];
            });
        }
        return $jsonContent;
    }
}
