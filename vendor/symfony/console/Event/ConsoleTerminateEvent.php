<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2022030310\Symfony\Component\Console\Event;

use ConfigTransformer2022030310\Symfony\Component\Console\Command\Command;
use ConfigTransformer2022030310\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer2022030310\Symfony\Component\Console\Output\OutputInterface;
/**
 * Allows to manipulate the exit code of a command after its execution.
 *
 * @author Francesco Levorato <git@flevour.net>
 */
final class ConsoleTerminateEvent extends \ConfigTransformer2022030310\Symfony\Component\Console\Event\ConsoleEvent
{
    /**
     * @var int
     */
    private $exitCode;
    public function __construct(\ConfigTransformer2022030310\Symfony\Component\Console\Command\Command $command, \ConfigTransformer2022030310\Symfony\Component\Console\Input\InputInterface $input, \ConfigTransformer2022030310\Symfony\Component\Console\Output\OutputInterface $output, int $exitCode)
    {
        parent::__construct($command, $input, $output);
        $this->setExitCode($exitCode);
    }
    public function setExitCode(int $exitCode) : void
    {
        $this->exitCode = $exitCode;
    }
    public function getExitCode() : int
    {
        return $this->exitCode;
    }
}
