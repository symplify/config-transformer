<?php

declare (strict_types=1);
namespace ConfigTransformer202108193\Symplify\ConfigTransformer\Configuration;

use ConfigTransformer202108193\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202108193\Symplify\ConfigTransformer\ValueObject\Format;
use ConfigTransformer202108193\Symplify\ConfigTransformer\ValueObject\Option;
use ConfigTransformer202108193\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
final class Configuration implements \ConfigTransformer202108193\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface
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
        $this->source = (array) $input->getArgument(\ConfigTransformer202108193\Symplify\ConfigTransformer\ValueObject\Option::SOURCES);
        $this->targetSymfonyVersion = \floatval($input->getOption(\ConfigTransformer202108193\Symplify\ConfigTransformer\ValueObject\Option::TARGET_SYMFONY_VERSION));
        $this->isDryRun = \boolval($input->getOption(\ConfigTransformer202108193\Symplify\ConfigTransformer\ValueObject\Option::DRY_RUN));
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
        return [\ConfigTransformer202108193\Symplify\ConfigTransformer\ValueObject\Format::YAML, \ConfigTransformer202108193\Symplify\ConfigTransformer\ValueObject\Format::YML, \ConfigTransformer202108193\Symplify\ConfigTransformer\ValueObject\Format::XML];
    }
}
