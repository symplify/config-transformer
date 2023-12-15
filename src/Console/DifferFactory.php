<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Console;

use SebastianBergmann\Diff\Differ;
use SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use Symplify\ConfigTransformer\Reflection\PrivatesAccessor;

/**
 * @api used in factory
 */
final class DifferFactory
{
    public function create(): Differ
    {
        $unifiedDiffOutputBuilder = new UnifiedDiffOutputBuilder('');
        PrivatesAccessor::writePrivateProperty($unifiedDiffOutputBuilder, 'contextLines', 10000);

        return new Differ($unifiedDiffOutputBuilder);
    }
}
