<?php

declare (strict_types=1);
namespace ConfigTransformer2021081610\Symplify\ConfigTransformer\Configuration;

use ConfigTransformer2021081610\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer2021081610\Symplify\ConfigTransformer\ValueObject\Format;
use ConfigTransformer2021081610\Symplify\ConfigTransformer\ValueObject\Option;
use ConfigTransformer2021081610\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
final class Configuration implements \ConfigTransformer2021081610\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface
{
    /**
     * @var string[]
     */
    private $source = [];
    /**
     * @var float|null
     */
    private $targetSymfonyVersion;
    /**
     * @var bool
     */
    private $isDryRun = \false;
    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     */
    public function populateFromInput($input) : void
    {
        $this->source = (array) $input->getArgument(\ConfigTransformer2021081610\Symplify\ConfigTransformer\ValueObject\Option::SOURCES);
        $this->targetSymfonyVersion = \floatval($input->getOption(\ConfigTransformer2021081610\Symplify\ConfigTransformer\ValueObject\Option::TARGET_SYMFONY_VERSION));
        $this->isDryRun = \boolval($input->getOption(\ConfigTransformer2021081610\Symplify\ConfigTransformer\ValueObject\Option::DRY_RUN));
    }
    /**
     * @return string[]
     */
    public function getSource() : array
    {
        return $this->source;
    }
    /**
     * @param float $symfonyVersion
     */
    public function isAtLeastSymfonyVersion($symfonyVersion) : bool
    {
        return $this->targetSymfonyVersion >= $symfonyVersion;
    }
    public function isDryRun() : bool
    {
        return $this->isDryRun;
    }
    /**
     * @param float $symfonyVersion
     */
    public function changeSymfonyVersion($symfonyVersion) : void
    {
        $this->targetSymfonyVersion = $symfonyVersion;
    }
    /**
     * @return string[]
     */
    public function getInputSuffixes() : array
    {
        return [\ConfigTransformer2021081610\Symplify\ConfigTransformer\ValueObject\Format::YAML, \ConfigTransformer2021081610\Symplify\ConfigTransformer\ValueObject\Format::YML, \ConfigTransformer2021081610\Symplify\ConfigTransformer\ValueObject\Format::XML];
    }
}
