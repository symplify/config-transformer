<?php

declare (strict_types=1);
namespace ConfigTransformer202301\Symplify\MonorepoBuilder\Release\Configuration;

use ConfigTransformer202301\PharIo\Version\Version;
use ConfigTransformer202301\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202301\Symplify\MonorepoBuilder\Release\Version\VersionFactory;
use ConfigTransformer202301\Symplify\MonorepoBuilder\ValueObject\Option;
final class VersionResolver
{
    /**
     * @var \Symplify\MonorepoBuilder\Release\Version\VersionFactory
     */
    private $versionFactory;
    public function __construct(VersionFactory $versionFactory)
    {
        $this->versionFactory = $versionFactory;
    }
    public function resolveVersion(InputInterface $input, string $stage) : Version
    {
        /** @var string $versionArgument */
        $versionArgument = $input->getArgument(Option::VERSION);
        return $this->versionFactory->createValidVersion($versionArgument, $stage);
    }
}
