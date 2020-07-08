<?php

declare(strict_types=1);

namespace Migrify\ConfigTransformer\Clarifier\Command;

use Migrify\ConfigTransformer\Clarifier\Clarifier\NeonYamlConfigClarifier;
use Migrify\ConfigTransformer\Clarifier\Finder\NeonAndYamlFinder;
use Migrify\ConfigTransformer\Clarifier\ValueObject\Option;
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
     * @var NeonAndYamlFinder
     */
    private $neonAndYamlFinder;

    /**
     * @var NeonYamlConfigClarifier
     */
    private $neonYamlConfigClarifier;

    public function __construct(
        SymfonyStyle $symfonyStyle,
        NeonAndYamlFinder $neonAndYamlFinder,
        NeonYamlConfigClarifier $neonYamlConfigClarifier
    ) {
        parent::__construct();

        $this->symfonyStyle = $symfonyStyle;
        $this->neonAndYamlFinder = $neonAndYamlFinder;
        $this->neonYamlConfigClarifier = $neonYamlConfigClarifier;
    }

    protected function configure(): void
    {
        $this->setName(CommandNaming::classToName(self::class));
        $this->setDescription('Clarify NEON/YAML syntax in provided files');
        $this->addArgument(Option::SOURCE, InputArgument::REQUIRED, 'Path to directory with NEON/YAML files');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $source */
        $source = (string) $input->getArgument(Option::SOURCE);

        $fileInfos = $this->neonAndYamlFinder->findYamlAndNeonFilesInSource($source);

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
