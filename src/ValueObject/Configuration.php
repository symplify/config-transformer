<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\ValueObject;

final class Configuration
{
    /**
     * @var string[]
     * @readonly
     */
    private $sources;
    /**
     * @readonly
     * @var bool
     */
    private $isDryRun;
    /**
     * @readonly
     * @var bool
     */
    private $areRoutesIncluded;
    /**
     * @param string[] $sources
     */
    public function __construct(array $sources, bool $isDryRun, bool $areRoutesIncluded)
    {
        $this->sources = $sources;
        $this->isDryRun = $isDryRun;
        $this->areRoutesIncluded = $areRoutesIncluded;
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
    public function areRoutesIncluded() : bool
    {
        return $this->areRoutesIncluded;
    }
}
