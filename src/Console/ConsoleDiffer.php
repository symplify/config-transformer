<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Console;

use SebastianBergmann\Diff\Differ;
use SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use Symplify\ConfigTransformer\Reflection\PrivatesAccessor;

final class ConsoleDiffer
{
    public function __construct(
        private readonly ColorConsoleDiffFormatter $colorConsoleDiffFormatter
    ) {
    }

    public function diff(string $old, string $new): string
    {
        $differ = $this->createDiffer();

        $diff = $differ->diff($old, $new);
        return $this->colorConsoleDiffFormatter->format($diff);
    }

    private function createDiffer(): Differ
    {
        $unifiedDiffOutputBuilder = new UnifiedDiffOutputBuilder('');
        PrivatesAccessor::writePrivateProperty($unifiedDiffOutputBuilder, 'contextLines', 10000);

        return new Differ($unifiedDiffOutputBuilder);
    }
}
