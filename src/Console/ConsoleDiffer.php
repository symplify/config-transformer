<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Console;

use ConfigTransformerPrefix202312\SebastianBergmann\Diff\Differ;
use ConfigTransformerPrefix202312\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use Symplify\ConfigTransformer\Reflection\PrivatesAccessor;
final class ConsoleDiffer
{
    /**
     * @readonly
     * @var \Symplify\ConfigTransformer\Console\ColorConsoleDiffFormatter
     */
    private $colorConsoleDiffFormatter;
    public function __construct(\Symplify\ConfigTransformer\Console\ColorConsoleDiffFormatter $colorConsoleDiffFormatter)
    {
        $this->colorConsoleDiffFormatter = $colorConsoleDiffFormatter;
    }
    public function diff(string $old, string $new) : string
    {
        $differ = $this->createDiffer();
        $diff = $differ->diff($old, $new);
        return $this->colorConsoleDiffFormatter->format($diff);
    }
    private function createDiffer() : Differ
    {
        $unifiedDiffOutputBuilder = new UnifiedDiffOutputBuilder('');
        PrivatesAccessor::writePrivateProperty($unifiedDiffOutputBuilder, 'contextLines', 10000);
        return new Differ($unifiedDiffOutputBuilder);
    }
}
