<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\ValueObject;

use Symplify\ConfigTransformer\Enum\Format;
final class Configuration
{
    /**
     * @var string[]
     */
    private $sources;
    /**
     * @var bool
     */
    private $isDryRun;
    /**
     * @param string[] $sources
     */
    public function __construct(array $sources, bool $isDryRun)
    {
        $this->sources = $sources;
        $this->isDryRun = $isDryRun;
    }
    /**
     * @return string[]
     */
    public function getSources() : array
    {
        return $this->sources;
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
        return [Format::YAML, Format::YML, Format::XML];
    }
}
