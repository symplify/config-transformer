<?php

declare (strict_types=1);
namespace ConfigTransformer202204144\Symplify\EasyTesting\Command;

use ConfigTransformer202204144\Symfony\Component\Console\Input\InputArgument;
use ConfigTransformer202204144\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202204144\Symfony\Component\Console\Output\OutputInterface;
use ConfigTransformer202204144\Symplify\EasyTesting\Finder\FixtureFinder;
use ConfigTransformer202204144\Symplify\EasyTesting\MissplacedSkipPrefixResolver;
use ConfigTransformer202204144\Symplify\EasyTesting\ValueObject\Option;
use ConfigTransformer202204144\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
final class ValidateFixtureSkipNamingCommand extends \ConfigTransformer202204144\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand
{
    /**
     * @var \Symplify\EasyTesting\MissplacedSkipPrefixResolver
     */
    private $missplacedSkipPrefixResolver;
    /**
     * @var \Symplify\EasyTesting\Finder\FixtureFinder
     */
    private $fixtureFinder;
    public function __construct(\ConfigTransformer202204144\Symplify\EasyTesting\MissplacedSkipPrefixResolver $missplacedSkipPrefixResolver, \ConfigTransformer202204144\Symplify\EasyTesting\Finder\FixtureFinder $fixtureFinder)
    {
        $this->missplacedSkipPrefixResolver = $missplacedSkipPrefixResolver;
        $this->fixtureFinder = $fixtureFinder;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setName('validate-fixture-skip-naming');
        $this->addArgument(\ConfigTransformer202204144\Symplify\EasyTesting\ValueObject\Option::SOURCE, \ConfigTransformer202204144\Symfony\Component\Console\Input\InputArgument::REQUIRED | \ConfigTransformer202204144\Symfony\Component\Console\Input\InputArgument::IS_ARRAY, 'Paths to analyse');
        $this->setDescription('Check that skipped fixture files (without `-----` separator) have a "skip" prefix');
    }
    protected function execute(\ConfigTransformer202204144\Symfony\Component\Console\Input\InputInterface $input, \ConfigTransformer202204144\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $source = (array) $input->getArgument(\ConfigTransformer202204144\Symplify\EasyTesting\ValueObject\Option::SOURCE);
        $fixtureFileInfos = $this->fixtureFinder->find($source);
        $incorrectAndMissingSkips = $this->missplacedSkipPrefixResolver->resolve($fixtureFileInfos);
        foreach ($incorrectAndMissingSkips->getIncorrectSkipFileInfos() as $incorrectSkipFileInfo) {
            $errorMessage = \sprintf('The file "%s" should drop the "skip/keep" prefix', $incorrectSkipFileInfo->getRelativeFilePathFromCwd());
            $this->symfonyStyle->note($errorMessage);
        }
        foreach ($incorrectAndMissingSkips->getMissingSkipFileInfos() as $missingSkipFileInfo) {
            $errorMessage = \sprintf('The file "%s" should start with "skip/keep" prefix', $missingSkipFileInfo->getRelativeFilePathFromCwd());
            $this->symfonyStyle->note($errorMessage);
        }
        $countError = $incorrectAndMissingSkips->getFileCount();
        if ($incorrectAndMissingSkips->getFileCount() === 0) {
            $message = \sprintf('All %d fixture files have valid names', \count($fixtureFileInfos));
            $this->symfonyStyle->success($message);
            return self::SUCCESS;
        }
        $errorMessage = \sprintf('Found %d test file fixtures with wrong prefix', $countError);
        $this->symfonyStyle->error($errorMessage);
        return self::FAILURE;
    }
}
