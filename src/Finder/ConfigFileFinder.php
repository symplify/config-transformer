<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Finder;

use Symplify\ConfigTransformer\ValueObject\Configuration;
use ConfigTransformerPrefix202302\Symplify\SmartFileSystem\Finder\SmartFinder;
use ConfigTransformerPrefix202302\Symplify\SmartFileSystem\SmartFileInfo;
final class ConfigFileFinder
{
    /**
     * @see https://regex101.com/r/jmxqCg/1
     * @var string
     */
    private const CONFIG_SUFFIXES_REGEX = '#\\.(yml|yaml|xml)$#';
    /**
     * @var \Symplify\SmartFileSystem\Finder\SmartFinder
     */
    private $smartFinder;
    public function __construct(SmartFinder $smartFinder)
    {
        $this->smartFinder = $smartFinder;
    }
    /**
     * @return SmartFileInfo[]
     */
    public function findFileInfos(Configuration $configuration) : array
    {
        return $this->smartFinder->find($configuration->getSources(), self::CONFIG_SUFFIXES_REGEX);
    }
}
