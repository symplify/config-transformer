<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\Clarifier\Command;

use Migrify\ConfigTransformer\Clarifier\Clarifier\NeonYamlConfigClarifier;
use Migrify\ConfigTransformer\Clarifier\ValueObject\Option;
use Migrify\ConfigTransformer\Finder\FileBySuffixFinder;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symplify\PackageBuilder\Console\Command\CommandNaming;
use Symplify\PackageBuilder\Console\ShellCode;

final class ClarifyCommand extends Command
{
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;

    /**
     * @var NeonYamlConfigClarifier
     */
    private $neonYamlConfigClarifier;

    /**
     * @var FileBySuffixFinder
     */
    private $fileBySuffixFinder;

    public function __construct(
        SymfonyStyle $symfonyStyle,
        FileBySuffixFinder $fileBySuffixFinder,
        NeonYamlConfigClarifier $neonYamlConfigClarifier
    ) {
        parent::__construct();

        $this->symfonyStyle = $symfonyStyle;
        $this->neonYamlConfigClarifier = $neonYamlConfigClarifier;
        $this->fileBySuffixFinder = $fileBySuffixFinder;
    }

    protected function configure(): void
    {
        $this->setName(CommandNaming::classToName(self::class));
        $this->setDescription('Clarify NEON/YAML syntax in provided files');
        $this->addArgument(
            Option::SOURCE,
            InputArgument::REQUIRED | InputArgument::IS_ARRAY,
            'Paths to s/directories with NEON/YAML'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var array $source */
        $source = (array) $input->getArgument(Option::SOURCE);

        $fileInfos = $this->fileBySuffixFinder->findInSourceBySuffixes($source, ['neon', 'yml', 'yaml']);

        foreach ($fileInfos as $fileInfo) {
            $message = sprintf('Processing "%s"', $fileInfo->getRelativeFilePathFromCwd());
            $this->symfonyStyle->title($message);

            $newContent = $this->neonYamlConfigClarifier->clarify($fileInfo->getContents(), $fileInfo->getSuffix());
            if ($newContent === null) {
                continue;
            }
            $message = sprintf('File "%s" was updated', $fileInfo->getRelativeFilePathFromCwd());

            $this->symfonyStyle->writeln($message);
        }

        $this->symfonyStyle->success('OK');

        return ShellCode::SUCCESS;
    }
}
