<?php

declare (strict_types=1);
namespace ConfigTransformer202106111\Symplify\PackageBuilder\Console\Command;

use ConfigTransformer202106111\Symfony\Component\Console\Command\Command;
use ConfigTransformer202106111\Symfony\Component\Console\Input\InputOption;
use ConfigTransformer202106111\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer202106111\Symplify\PackageBuilder\ValueObject\Option;
use ConfigTransformer202106111\Symplify\SmartFileSystem\FileSystemGuard;
use ConfigTransformer202106111\Symplify\SmartFileSystem\Finder\SmartFinder;
use ConfigTransformer202106111\Symplify\SmartFileSystem\SmartFileSystem;
abstract class AbstractSymplifyCommand extends \ConfigTransformer202106111\Symfony\Component\Console\Command\Command
{
    /**
     * @var SymfonyStyle
     */
    protected $symfonyStyle;
    /**
     * @var SmartFileSystem
     */
    protected $smartFileSystem;
    /**
     * @var SmartFinder
     */
    protected $smartFinder;
    /**
     * @var FileSystemGuard
     */
    protected $fileSystemGuard;
    public function __construct()
    {
        parent::__construct();
        $this->addOption(\ConfigTransformer202106111\Symplify\PackageBuilder\ValueObject\Option::CONFIG, 'c', \ConfigTransformer202106111\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to config file');
    }
    /**
     * @required
     */
    public function autowireAbstractSymplifyCommand(\ConfigTransformer202106111\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \ConfigTransformer202106111\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \ConfigTransformer202106111\Symplify\SmartFileSystem\Finder\SmartFinder $smartFinder, \ConfigTransformer202106111\Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard) : void
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->smartFileSystem = $smartFileSystem;
        $this->smartFinder = $smartFinder;
        $this->fileSystemGuard = $fileSystemGuard;
    }
}
