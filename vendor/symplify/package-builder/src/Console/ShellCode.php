<?php

declare (strict_types=1);
namespace ConfigTransformer202108303\Symplify\PackageBuilder\Console;

use ConfigTransformer202108303\Symfony\Component\Console\Command\Command;
/**
 * @deprecated Use symfony constants in directly
 * @see Command::FAILURE
 * @see Command::SUCCESS
 */
final class ShellCode
{
    /**
     * @var int
     *
     * @deprecated Use symfony constants in directly
     * @see Command::SUCCESS
     */
    public const SUCCESS = 0;
    /**
     * @var int
     *
     * @deprecated Use symfony constants in directly
     * @see Command::FAILURE
     */
    public const ERROR = 1;
}
