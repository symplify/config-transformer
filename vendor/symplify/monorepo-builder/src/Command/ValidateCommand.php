<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Command;

use ConfigTransformer202301\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202301\Symfony\Component\Console\Output\OutputInterface;
use ConfigTransformer202301\Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Validator\ConflictingPackageVersionsReporter;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Validator\SourcesPresenceValidator;
use ConfigTransformer202301\Symplify\MonorepoBuilder\VersionValidator;
use ConfigTransformer202301\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
final class ValidateCommand extends AbstractSymplifyCommand
{
    /**
     * @var \Symplify\MonorepoBuilder\FileSystem\ComposerJsonProvider
     */
    private $composerJsonProvider;
    /**
     * @var \Symplify\MonorepoBuilder\VersionValidator
     */
    private $versionValidator;
    /**
     * @var \Symplify\MonorepoBuilder\Validator\ConflictingPackageVersionsReporter
     */
    private $conflictingPackageVersionsReporter;
    /**
     * @var \Symplify\MonorepoBuilder\Validator\SourcesPresenceValidator
     */
    private $sourcesPresenceValidator;
    public function __construct(ComposerJsonProvider $composerJsonProvider, VersionValidator $versionValidator, ConflictingPackageVersionsReporter $conflictingPackageVersionsReporter, SourcesPresenceValidator $sourcesPresenceValidator)
    {
        $this->composerJsonProvider = $composerJsonProvider;
        $this->versionValidator = $versionValidator;
        $this->conflictingPackageVersionsReporter = $conflictingPackageVersionsReporter;
        $this->sourcesPresenceValidator = $sourcesPresenceValidator;
        parent::__construct();
    }
    protected function configure() : void
    {
        $this->setName('validate');
        $this->setDescription('Validates synchronized versions in "composer.json" in all found packages.');
    }
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $this->sourcesPresenceValidator->validatePackageComposerJsons();
        $conflictingPackageVersions = $this->versionValidator->findConflictingPackageVersionsInFileInfos($this->composerJsonProvider->getRootAndPackageFileInfos());
        if ($conflictingPackageVersions === []) {
            $this->symfonyStyle->success('All packages "composer.json" files use same package versions.');
            return self::SUCCESS;
        }
        $this->conflictingPackageVersionsReporter->report($conflictingPackageVersions);
        return self::FAILURE;
    }
}
