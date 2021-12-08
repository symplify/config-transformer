<?php

declare (strict_types=1);
namespace ConfigTransformer2021120810\Symplify\PhpConfigPrinter\ValueObject;

final class MethodName
{
    /**
     * @var string
     */
    public const SET = 'set';
    /**
     * @var string
     */
    public const ALIAS = 'alias';
    /**
     * @var string
     */
    public const DEFAULTS = 'defaults';
    /**
     * @var string
     */
    public const INSTANCEOF = 'instanceof';
    /**
     * @var string
     */
    public const EXTENSION = 'extension';
}
