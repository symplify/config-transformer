<?php

declare(strict_types=1);

namespace Symplify\ConfigTransformer\Console\Style;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @api used in factory
 */
final class SymfonyStyleFactory
{
    public function create(): SymfonyStyle
    {
        return new SymfonyStyle(new ArrayInput([]), new ConsoleOutput());
    }
}
