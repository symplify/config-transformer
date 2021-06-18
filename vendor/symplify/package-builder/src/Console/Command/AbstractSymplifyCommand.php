<?php

declare (strict_types=1);
namespace ConfigTransformer2021061810\Symplify\PackageBuilder\Console\Command;

use ConfigTransformer2021061810\Symfony\Component\Console\Command\Command;
use ConfigTransformer2021061810\Symfony\Component\Console\Input\InputOption;
use ConfigTransformer2021061810\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer2021061810\Symfony\Contracts\Service\Attribute\Required;
use ConfigTransformer2021061810\Symplify\PackageBuilder\ValueObject\Option;
use ConfigTransformer2021061810\Symplify\SmartFileSystem\FileSystemGuard;
use ConfigTransformer2021061810\Symplify\SmartFileSystem\Finder\SmartFinder;
use ConfigTransformer2021061810\Symplify\SmartFileSystem\SmartFileSystem;
abstract class AbstractSymplifyCommand extends \ConfigTransformer2021061810\Symfony\Component\Console\Command\Command
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
        $this->addOption(\ConfigTransformer2021061810\Symplify\PackageBuilder\ValueObject\Option::CONFIG, 'c', \ConfigTransformer2021061810\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'Path to config file');
    }
    #[Required]
    public function autowireAbstractSymplifyCommand(\ConfigTransformer2021061810\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle, \ConfigTransformer2021061810\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \ConfigTransformer2021061810\Symplify\SmartFileSystem\Finder\SmartFinder $smartFinder, \ConfigTransformer2021061810\Symplify\SmartFileSystem\FileSystemGuard $fileSystemGuard) : void
    {
        $this->symfonyStyle = $symfonyStyle;
        $this->smartFileSystem = $smartFileSystem;
        $this->smartFinder = $smartFinder;
        $this->fileSystemGuard = $fileSystemGuard;
    }
}
