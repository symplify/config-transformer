<?php

declare (strict_types=1);
namespace ConfigTransformer202108311\Symplify\ConfigTransformer\ValueObject;

final class Configuration
{
    /**
     * @var mixed[]
     */
    private $sources;
    /**
     * @var float
     */
    private $targetSymfonyVersion;
    /**
     * @var bool
     */
    private $isDryRun;
    /**
     * @param string[] $sources
     */
    public function __construct(array $sources, float $targetSymfonyVersion, bool $isDryRun)
    {
        $this->sources = $sources;
        $this->targetSymfonyVersion = $targetSymfonyVersion;
        $this->isDryRun = $isDryRun;
    }
    /**
     * @return string[]
     */
    public function getSources() : array
    {
        return $this->sources;
    }
    public function isAtLeastSymfonyVersion(float $symfonyVersion) : bool
    {
        return $this->targetSymfonyVersion >= $symfonyVersion;
    }
    public function isDryRun() : bool
    {
        return $this->isDryRun;
    }
    /**
     * @return string[]
     */
    public function getInputSuffixes() : array
    {
        return [\ConfigTransformer202108311\Symplify\ConfigTransformer\ValueObject\Format::YAML, \ConfigTransformer202108311\Symplify\ConfigTransformer\ValueObject\Format::YML, \ConfigTransformer202108311\Symplify\ConfigTransformer\ValueObject\Format::XML];
    }
}
