<?php

declare (strict_types=1);
namespace ConfigTransformer2021080510\Symplify\SymplifyKernel\Strings;

use ConfigTransformer2021080510\Nette\Utils\Strings;
use ConfigTransformer2021080510\Symplify\SymplifyKernel\Exception\HttpKernel\TooGenericKernelClassException;
use ConfigTransformer2021080510\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel;
final class KernelUniqueHasher
{
    /**
     * @var \Symplify\SymplifyKernel\Strings\StringsConverter
     */
    private $stringsConverter;
    public function __construct()
    {
        $this->stringsConverter = new \ConfigTransformer2021080510\Symplify\SymplifyKernel\Strings\StringsConverter();
    }
    public function hashKernelClass(string $kernelClass) : string
    {
        $this->ensureIsNotGenericKernelClass($kernelClass);
        $shortClassName = (string) \ConfigTransformer2021080510\Nette\Utils\Strings::after($kernelClass, '\\', -1);
        $userSpecificShortClassName = $shortClassName . \get_current_user();
        return $this->stringsConverter->camelCaseToGlue($userSpecificShortClassName, '_');
    }
    private function ensureIsNotGenericKernelClass(string $kernelClass) : void
    {
        if ($kernelClass !== \ConfigTransformer2021080510\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel::class) {
            return;
        }
        $message = \sprintf('Instead of "%s", provide final Kernel class', \ConfigTransformer2021080510\Symplify\SymplifyKernel\HttpKernel\AbstractSymplifyKernel::class);
        throw new \ConfigTransformer2021080510\Symplify\SymplifyKernel\Exception\HttpKernel\TooGenericKernelClassException($message);
    }
}
