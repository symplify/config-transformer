<?php

declare (strict_types=1);
namespace ConfigTransformer202106117\Symplify\EasyTesting\Finder;

use ConfigTransformer202106117\Symfony\Component\Finder\Finder;
use ConfigTransformer202106117\Symplify\SmartFileSystem\Finder\FinderSanitizer;
use ConfigTransformer202106117\Symplify\SmartFileSystem\SmartFileInfo;
final class FixtureFinder
{
    /**
     * @var FinderSanitizer
     */
    private $finderSanitizer;
    public function __construct(\ConfigTransformer202106117\Symplify\SmartFileSystem\Finder\FinderSanitizer $finderSanitizer)
    {
        $this->finderSanitizer = $finderSanitizer;
    }
    /**
     * @return SmartFileInfo[]
     */
    public function find(array $sources) : array
    {
        $finder = new \ConfigTransformer202106117\Symfony\Component\Finder\Finder();
        $finder->files()->in($sources)->name('*.php.inc')->path('Fixture')->sortByName();
        return $this->finderSanitizer->sanitize($finder);
    }
}
