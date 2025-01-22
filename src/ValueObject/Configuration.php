<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\ValueObject;

final class Configuration
{
    /**
     * @param string[] $sources
     */
    public function __construct(
        private readonly array $sources,
        private readonly bool $isDryRun,
        private readonly bool $areRoutesIncluded
    ) {
    }

    /**
     * @return string[]
     */
    public function getSources(): array
    {
        return $this->sources;
    }

    public function isDryRun(): bool
    {
        return $this->isDryRun;
    }

    public function areRoutesIncluded(): bool
    {
        return $this->areRoutesIncluded;
    }
}
