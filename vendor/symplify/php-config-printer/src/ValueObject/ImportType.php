<?php

declare (strict_types=1);
namespace ConfigTransformer202109298\Symplify\PhpConfigPrinter\ValueObject;

/**
 * @enum
 */
final class ImportType
{
    /**
     * @var string
     */
    public const CLASS_TYPE = 'normal';
    /**
     * @var string
     */
    public const FUNCTION_TYPE = 'function';
    /**
     * @var string
     */
    public const CONSTANT_TYPE = 'constant';
}
