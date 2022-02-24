<?php

declare (strict_types=1);
namespace ConfigTransformer202202248\Symplify\PackageBuilder\Console\Output;

use ConfigTransformer202202248\SebastianBergmann\Diff\Differ;
use ConfigTransformer202202248\Symplify\PackageBuilder\Console\Formatter\ColorConsoleDiffFormatter;
/**
 * @api
 */
final class ConsoleDiffer
{
    /**
     * @var \SebastianBergmann\Diff\Differ
     */
    private $differ;
    /**
     * @var \Symplify\PackageBuilder\Console\Formatter\ColorConsoleDiffFormatter
     */
    private $colorConsoleDiffFormatter;
    public function __construct(\ConfigTransformer202202248\SebastianBergmann\Diff\Differ $differ, \ConfigTransformer202202248\Symplify\PackageBuilder\Console\Formatter\ColorConsoleDiffFormatter $colorConsoleDiffFormatter)
    {
        $this->differ = $differ;
        $this->colorConsoleDiffFormatter = $colorConsoleDiffFormatter;
    }
    public function diff(string $old, string $new) : string
    {
        $diff = $this->differ->diff($old, $new);
        return $this->colorConsoleDiffFormatter->format($diff);
    }
}
