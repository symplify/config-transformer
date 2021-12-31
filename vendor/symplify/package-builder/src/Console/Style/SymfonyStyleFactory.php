<?php

declare (strict_types=1);
namespace ConfigTransformer202112318\Symplify\PackageBuilder\Console\Style;

use ConfigTransformer202112318\Symfony\Component\Console\Application;
use ConfigTransformer202112318\Symfony\Component\Console\Input\ArgvInput;
use ConfigTransformer202112318\Symfony\Component\Console\Output\ConsoleOutput;
use ConfigTransformer202112318\Symfony\Component\Console\Output\OutputInterface;
use ConfigTransformer202112318\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer202112318\Symplify\EasyTesting\PHPUnit\StaticPHPUnitEnvironment;
use ConfigTransformer202112318\Symplify\PackageBuilder\Reflection\PrivatesCaller;
/**
 * @api
 */
final class SymfonyStyleFactory
{
    /**
     * @var \Symplify\PackageBuilder\Reflection\PrivatesCaller
     */
    private $privatesCaller;
    public function __construct()
    {
        $this->privatesCaller = new \ConfigTransformer202112318\Symplify\PackageBuilder\Reflection\PrivatesCaller();
    }
    public function create() : \ConfigTransformer202112318\Symfony\Component\Console\Style\SymfonyStyle
    {
        // to prevent missing argv indexes
        if (!isset($_SERVER['argv'])) {
            $_SERVER['argv'] = [];
        }
        $argvInput = new \ConfigTransformer202112318\Symfony\Component\Console\Input\ArgvInput();
        $consoleOutput = new \ConfigTransformer202112318\Symfony\Component\Console\Output\ConsoleOutput();
        // to configure all -v, -vv, -vvv options without memory-lock to Application run() arguments
        $this->privatesCaller->callPrivateMethod(new \ConfigTransformer202112318\Symfony\Component\Console\Application(), 'configureIO', [$argvInput, $consoleOutput]);
        // --debug is called
        if ($argvInput->hasParameterOption('--debug')) {
            $consoleOutput->setVerbosity(\ConfigTransformer202112318\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG);
        }
        // disable output for tests
        if (\ConfigTransformer202112318\Symplify\EasyTesting\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            $consoleOutput->setVerbosity(\ConfigTransformer202112318\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET);
        }
        return new \ConfigTransformer202112318\Symfony\Component\Console\Style\SymfonyStyle($argvInput, $consoleOutput);
    }
}
