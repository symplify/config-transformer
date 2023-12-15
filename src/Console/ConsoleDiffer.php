<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Console;

use SebastianBergmann\Diff\Differ;

final class ConsoleDiffer
{
    public function __construct(
        private readonly Differ $differ,
        private readonly ColorConsoleDiffFormatter $colorConsoleDiffFormatter
    ) {
    }

    public function diff(string $old, string $new): string
    {
        $diff = $this->differ->diff($old, $new);
        return $this->colorConsoleDiffFormatter->format($diff);
    }
}
