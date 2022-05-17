<?php

declare (strict_types=1);
namespace ConfigTransformer2022051710\Symplify\PackageBuilder\Diff\Output;

use ConfigTransformer2022051710\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder;
use ConfigTransformer2022051710\Symplify\PackageBuilder\Reflection\PrivatesAccessor;
/**
 * @api
 * Creates @see UnifiedDiffOutputBuilder with "$contextLines = 1000;"
 */
final class CompleteUnifiedDiffOutputBuilderFactory
{
    /**
     * @var \Symplify\PackageBuilder\Reflection\PrivatesAccessor
     */
    private $privatesAccessor;
    public function __construct(\ConfigTransformer2022051710\Symplify\PackageBuilder\Reflection\PrivatesAccessor $privatesAccessor)
    {
        $this->privatesAccessor = $privatesAccessor;
    }
    /**
     * @api
     */
    public function create() : \ConfigTransformer2022051710\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder
    {
        $unifiedDiffOutputBuilder = new \ConfigTransformer2022051710\SebastianBergmann\Diff\Output\UnifiedDiffOutputBuilder('');
        $this->privatesAccessor->setPrivateProperty($unifiedDiffOutputBuilder, 'contextLines', 10000);
        return $unifiedDiffOutputBuilder;
    }
}
