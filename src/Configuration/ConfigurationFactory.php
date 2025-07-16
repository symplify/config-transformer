<?php

declare (strict_types=1);
namespace Symplify\ConfigTransformer\Configuration;

use ConfigTransformerPrefix202507\Symfony\Component\Console\Input\InputInterface;
use Symplify\ConfigTransformer\ValueObject\Configuration;
use Symplify\ConfigTransformer\ValueObject\Option;
final class ConfigurationFactory
{
    /**
     * @var string[]
     */
    private const DEFAULT_CONFIG_DIRECTORY = ['config', 'app/config'];
    public function createFromInput(InputInterface $input) : Configuration
    {
        $source = (array) $input->getArgument(Option::SOURCES);
        // pick most likely config directories
        if ($source === []) {
            foreach (self::DEFAULT_CONFIG_DIRECTORY as $defaultConfigDirectory) {
                if (\is_dir(\getcwd() . '/' . $defaultConfigDirectory)) {
                    $source[] = \getcwd() . '/' . $defaultConfigDirectory;
                }
            }
        }
        $isDryRun = (bool) $input->getOption(Option::DRY_RUN);
        $areRoutesIncluded = !$input->getOption(Option::SKIP_ROUTES);
        return new Configuration($source, $isDryRun, $areRoutesIncluded);
    }
}
