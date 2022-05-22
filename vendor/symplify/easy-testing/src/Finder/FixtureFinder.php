<?php

declare (strict_types=1);
namespace ConfigTransformer2022052210\Symplify\EasyTesting\Finder;

use ConfigTransformer2022052210\Symfony\Component\Finder\Finder;
use ConfigTransformer2022052210\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use ConfigTransformer2022052210\Symplify\SmartFileSystem\SmartFileInfo;
final class FixtureFinder
{
    /**
     * @var \Symplify\SmartFileSystem\Finder\FinderSanitizer
     */
    private $finderSanitizer;
    public function __construct(\ConfigTransformer2022052210\Symplify\SmartFileSystem\Finder\FinderSanitizer $finderSanitizer)
    {
        $this->finderSanitizer = $finderSanitizer;
    }
    /**
     * @param string[] $sources
     * @return SmartFileInfo[]
     */
    public function find(array $sources) : array
    {
        $finder = new \ConfigTransformer2022052210\Symfony\Component\Finder\Finder();
        $finder->files()->in($sources)->name('*.php.inc')->path('Fixture')->sortByName();
        return $this->finderSanitizer->sanitize($finder);
    }
}
