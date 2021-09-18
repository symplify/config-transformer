<?php

declare (strict_types=1);
namespace ConfigTransformer202109184\Symplify\SymplifyKernel\Strings;

use ConfigTransformer202109184\Nette\Utils\Strings;
use ConfigTransformer202109184\Symplify\SymplifyKernel\Exception\HttpKernel\TooGenericKernelClassException;
use ConfigTransformer202109184\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class KernelUniqueHasher
{
    /**
     * @var \Symplify\SymplifyKernel\Strings\StringsConverter
     */
    private $stringsConverter;
    public function __construct()
    {
        $this->stringsConverter = new \ConfigTransformer202109184\Symplify\SymplifyKernel\Strings\StringsConverter();
    }
    public function hashKernelClass(string $kernelClass) : string
    {
        $this->ensureIsNotGenericKernelClass($kernelClass);
        $shortClassName = (string) \ConfigTransformer202109184\Nette\Utils\Strings::after($kernelClass, '\\', -1);
        $userSpecificShortClassName = $shortClassName . \get_current_user();
        return $this->stringsConverter->camelCaseToGlue($userSpecificShortClassName, '_');
    }
    private function ensureIsNotGenericKernelClass(string $kernelClass) : void
    {
        if ($kernelClass !== \ConfigTransformer202109184\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel::class) {
            return;
        }
        $message = \sprintf('Instead of "%s", provide final Kernel class', \ConfigTransformer202109184\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel::class);
        throw new \ConfigTransformer202109184\Symplify\SymplifyKernel\Exception\HttpKernel\TooGenericKernelClassException($message);
    }
}
