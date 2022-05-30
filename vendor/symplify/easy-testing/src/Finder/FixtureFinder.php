<?php

declare (strict_types=1);
namespace ConfigTransformer202205307\Symplify\EasyTesting\Finder;

use ConfigTransformer202205307\Symfony\Component\Finder\Finder;
use ConfigTransformer202205307\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use ConfigTransformer202205307\Symplify\SmartFileSystem\SmartFileInfo;
final class FixtureFinder
{
    /**
     * @var \Symplify\SmartFileSystem\Finder\FinderSanitizer
     */
    private $finderSanitizer;
    public function __construct(\ConfigTransformer202205307\Symplify\SmartFileSystem\Finder\FinderSanitizer $finderSanitizer)
    {
        $this->finderSanitizer = $finderSanitizer;
    }
    /**
     * @param string[] $sources
     * @return SmartFileInfo[]
     */
    public function find(array $sources) : array
    {
        $finder = new \ConfigTransformer202205307\Symfony\Component\Finder\Finder();
        $finder->files()->in($sources)->name('*.php.inc')->path('Fixture')->sortByName();
        return $this->finderSanitizer->sanitize($finder);
    }
}
