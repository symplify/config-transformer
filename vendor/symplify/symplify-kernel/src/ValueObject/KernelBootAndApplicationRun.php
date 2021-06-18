<?php

declare (strict_types=1);
namespace ConfigTransformer202106185\Symplify\SymplifyKernel\ValueObject;

use ConfigTransformer202106185\Symfony\Component\Console\Application;
use ConfigTransformer202106185\Symfony\Component\HttpKernel\KernelInterface;
use ConfigTransformer202106185\Symplify\PackageBuilder\Console\Input\StaticInputDetector;
use ConfigTransformer202106185\Symplify\PackageBuilder\Console\ShellCode;
use ConfigTransformer202106185\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory;
use ConfigTransformer202106185\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface;
use ConfigTransformer202106185\Symplify\SmartFileSystem\SmartFileInfo;
use ConfigTransformer202106185\Symplify\SymplifyKernel\Exception\BootException;
use Throwable;
final class KernelBootAndApplicationRun
{
    /**
     * @var class-string
     */
    private $kernelClass;
    /**
     * @var string[]|SmartFileInfo[]
     */
    private $extraConfigs = [];
    /**
     * @param class-string $kernelClass
     * @param string[]|SmartFileInfo[] $extraConfigs
     */
    public function __construct(string $kernelClass, array $extraConfigs = [])
    {
        $this->setKernelClass($kernelClass);
        $this->extraConfigs = $extraConfigs;
    }
    public function run() : void
    {
        try {
            $this->booKernelAndRunApplication();
        } catch (\Throwable $throwable) {
            $symfonyStyleFactory = new \ConfigTransformer202106185\Symplify\PackageBuilder\Console\Style\SymfonyStyleFactory();
            $symfonyStyle = $symfonyStyleFactory->create();
            $symfonyStyle->error($throwable->getMessage());
            exit(\ConfigTransformer202106185\Symplify\PackageBuilder\Console\ShellCode::ERROR);
        }
    }
    private function createKernel() : \ConfigTransformer202106185\Symfony\Component\HttpKernel\KernelInterface
    {
        // random has is needed, so cache is invalidated and changes from config are loaded
        $environment = 'prod' . \random_int(1, 100000);
        $kernelClass = $this->kernelClass;
        $kernel = new $kernelClass($environment, \ConfigTransformer202106185\Symplify\PackageBuilder\Console\Input\StaticInputDetector::isDebug());
        $this->setExtraConfigs($kernel, $kernelClass);
        return $kernel;
    }
    private function booKernelAndRunApplication() : void
    {
        $kernel = $this->createKernel();
        if ($kernel instanceof \ConfigTransformer202106185\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface && $this->extraConfigs !== []) {
            $kernel->setConfigs($this->extraConfigs);
        }
        $kernel->boot();
        $container = $kernel->getContainer();
        /** @var Application $application */
        $application = $container->get(\ConfigTransformer202106185\Symfony\Component\Console\Application::class);
        exit($application->run());
    }
    private function setExtraConfigs(\ConfigTransformer202106185\Symfony\Component\HttpKernel\KernelInterface $kernel, string $kernelClass) : void
    {
        if ($this->extraConfigs === []) {
            return;
        }
        if (\is_a($kernel, \ConfigTransformer202106185\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface::class, \true)) {
            /** @var ExtraConfigAwareKernelInterface $kernel */
            $kernel->setConfigs($this->extraConfigs);
        } else {
            $message = \sprintf('Extra configs are set, but the "%s" kernel class is missing "%s" interface', $kernelClass, \ConfigTransformer202106185\Symplify\PackageBuilder\Contract\HttpKernel\ExtraConfigAwareKernelInterface::class);
            throw new \ConfigTransformer202106185\Symplify\SymplifyKernel\Exception\BootException($message);
        }
    }
    /**
     * @param class-string $kernelClass
     */
    private function setKernelClass(string $kernelClass) : void
    {
        if (!\is_a($kernelClass, \ConfigTransformer202106185\Symfony\Component\HttpKernel\KernelInterface::class, \true)) {
            $message = \sprintf('Class "%s" must by type of "%s"', $kernelClass, \ConfigTransformer202106185\Symfony\Component\HttpKernel\KernelInterface::class);
            throw new \ConfigTransformer202106185\Symplify\SymplifyKernel\Exception\BootException($message);
        }
        $this->kernelClass = $kernelClass;
    }
}
