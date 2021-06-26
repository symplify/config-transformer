<?php

declare (strict_types=1);
namespace ConfigTransformer202106265\Symplify\EasyTesting\Finder;

use ConfigTransformer202106265\Symfony\Component\Finder\Finder;
use ConfigTransformer202106265\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use ConfigTransformer202106265\Symplify\SmartFileSystem\SmartFileInfo;
final class FixtureFinder
{
    /**
     * @var \Symplify\SmartFileSystem\Finder\FinderSanitizer
     */
    private $finderSanitizer;
    public function __construct(\ConfigTransformer202106265\Symplify\SmartFileSystem\Finder\FinderSanitizer $finderSanitizer)
    {
        $this->finderSanitizer = $finderSanitizer;
    }
    /**
     * @return SmartFileInfo[]
     */
    public function find(array $sources) : array
    {
        $finder = new \ConfigTransformer202106265\Symfony\Component\Finder\Finder();
        $finder->files()->in($sources)->name('*.php.inc')->path('Fixture')->sortByName();
        return $this->finderSanitizer->sanitize($finder);
    }
}
