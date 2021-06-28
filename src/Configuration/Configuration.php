<?php

declare (strict_types=1);
namespace ConfigTransformer202106289\Symplify\ConfigTransformer\Configuration;

use ConfigTransformer202106289\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202106289\Symplify\ConfigTransformer\ValueObject\Format;
use ConfigTransformer202106289\Symplify\ConfigTransformer\ValueObject\Option;
use ConfigTransformer202106289\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface;
final class Configuration implements \ConfigTransformer202106289\Symplify\PhpConfigPrinter\Contract\SymfonyVersionFeatureGuardInterface
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
    public function populateFromInput(\ConfigTransformer202106289\Symfony\Component\Console\Input\InputInterface $input) : void
    {
        $this->source = (array) $input->getArgument(\ConfigTransformer202106289\Symplify\ConfigTransformer\ValueObject\Option::SOURCES);
        $this->targetSymfonyVersion = \floatval($input->getOption(\ConfigTransformer202106289\Symplify\ConfigTransformer\ValueObject\Option::TARGET_SYMFONY_VERSION));
        $this->isDryRun = \boolval($input->getOption(\ConfigTransformer202106289\Symplify\ConfigTransformer\ValueObject\Option::DRY_RUN));
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
        return [\ConfigTransformer202106289\Symplify\ConfigTransformer\ValueObject\Format::YAML, \ConfigTransformer202106289\Symplify\ConfigTransformer\ValueObject\Format::YML, \ConfigTransformer202106289\Symplify\ConfigTransformer\ValueObject\Format::XML];
    }
}
