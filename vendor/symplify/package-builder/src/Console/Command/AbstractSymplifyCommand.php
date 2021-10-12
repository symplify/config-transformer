<?php

declare (strict_types=1);
namespace ConfigTransformer2021101210\Symplify\PackageBuilder\Console\Command;

use ConfigTransformer2021101210\Symfony\Component\Console\Command\Command;
use ConfigTransformer2021101210\Symfony\Component\Console\Input\InputOption;
use ConfigTransformer2021101210\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer2021101210\Symfony\Contracts\Service\Attribute\Required;
use ConfigTransformer2021101210\Symplify\PackageBuilder\ValueObject\Option;
use ConfigTransformer2021101210\Symplify\SmartFileSystem\FileSystemGuard;
use ConfigTransformer2021101210\Symplify\SmartFileSystem\Finder\SmartFinder;
use ConfigTransformer2021101210\Symplify\SmartFileSystem\SmartFileSystem;
abstract class AbstractSymplifyCommand extends \ConfigTransformer2021101210\Symfony\Component\Console\Command\Command
{
    /**
     * @var \Symfony\Component\Console\Style\SymfonyStyle
     */
    protected $symfonyStyle;
    /**
     * @var \Symplify\SmartFileSystem\SmartFileSystem
     */
    protected $smartFileSystem;
    /**
     * @var \Symplify\SmartFileSystem\Finder\SmartFinder
     */
    protected $smartFinder;
    /**
     * @var \Symplify\SmartFileSystem\FileSystemGuard
     */
    protected $fileSystemGuard;
    public function __construct()
    {
        parent::__construct();
        $this->addOption(\ConfigTransformer2021101210\Symplify\PackageBuilder\ValueObject\Option::CONFIG, 'c', \ConfigTransformer2021101210\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to config file');
    }
    /**
     * @required
     */
    public function autowireAbstractSymplifyCommand(\ConfigTransformer2021101210\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \ConfigTransformer2021101210\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \ConfigTransformer2021101210\Symplify\SmartFileSystem\Finder\SmartFinder $smartFinder, \ConfigTransformer2021101210\Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard) : void
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->smartFileSystem = $smartFileSystem;
        $this->smartFinder = $smartFinder;
        $this->fileSystemGuard = $fileSystemGuard;
    }
}
