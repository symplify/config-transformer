<?php

declare (strict_types=1);
namespace ConfigTransformerPrefix202310\Symplify\PackageBuilder\Diff;

use ConfigTransformerPrefix202310\SebastianBergmann\Diff\Differ;
use ConfigTransformerPrefix202310\Symplify\PackageBuilder\Diff\Output\CompleteUnifiedDiffOutputBuilderFactory;
use ConfigTransformerPrefix202310\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
final class DifferFactory
{
    /**
     * @api
     */
    public function create() : Differ
    {
        $completeUnifiedDiffOutputBuilderFactory = new CompleteUnifiedDiffOutputBuilderFactory(new PrivatesAccessor());
        $unifiedDiffOutputBuilder = $completeUnifiedDiffOutputBuilderFactory->create();
        return new Differ($unifiedDiffOutputBuilder);
    }
}
