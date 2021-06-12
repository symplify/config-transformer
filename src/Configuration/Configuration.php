<?php

declare (strict_types=1);
namespace ConfigTransformer2021061210\Symplify\ConfigTransformer\Configuration;

use ConfigTransformer2021061210\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer2021061210\Symplify\ConfigTransformer\ValueObject\Format;
use ConfigTransformer2021061210\Symplify\ConfigTransformer\ValueObject\Option;
use ConfigTransformer2021061210\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
final class Configuration implements \ConfigTransformer2021061210\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface
{
    /**
     * @var string[]
     */
    private $source = [];
    /**
     * @var float
     */
    private $targetSymfonyVersion;
    /**
     * @var bool
     */
    private $isDryRun = \false;
    public function populateFromInput(\ConfigTransformer2021061210\Symfony\Component\Console\Input\InputInterface $input) : void
    {
        $this->source = (array) $input->getArgument(\ConfigTransformer2021061210\Symplify\ConfigTransformer\ValueObject\Option::SOURCES);
        $this->targetSymfonyVersion = \floatval($input->getOption(\ConfigTransformer2021061210\Symplify\ConfigTransformer\ValueObject\Option::TARGET_SYMFONY_VERSION));
        $this->isDryRun = \boolval($input->getOption(\ConfigTransformer2021061210\Symplify\ConfigTransformer\ValueObject\Option::DRY_RUN));
    }
    /**
     * @return string[]
     */
    public function getSource() : array
    {
        return $this->source;
    }
    public function isAtLeastSymfonyVersion(float $symfonyVersion) : bool
    {
        return $this->targetSymfonyVersion >= $symfonyVersion;
    }
    public function isDryRun() : bool
    {
        return $this->isDryRun;
    }
    public function changeSymfonyVersion(float $symfonyVersion) : void
    {
        $this->targetSymfonyVersion = $symfonyVersion;
    }
    /**
     * @return string[]
     */
    public function getInputSuffixes() : array
    {
        return [\ConfigTransformer2021061210\Symplify\ConfigTransformer\ValueObject\Format::YAML, \ConfigTransformer2021061210\Symplify\ConfigTransformer\ValueObject\Format::YML, \ConfigTransformer2021061210\Symplify\ConfigTransformer\ValueObject\Format::XML];
    }
}
