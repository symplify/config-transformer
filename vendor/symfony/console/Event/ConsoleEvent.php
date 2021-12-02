<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2021120210\Symfony\Component\Console\Event;

use ConfigTransformer2021120210\Symfony\Component\Console\Command\Command;
use ConfigTransformer2021120210\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer2021120210\Symfony\Component\Console\Output\OutputInterface;
use ConfigTransformer2021120210\Symfony\Contracts\EventDispatcher\Event;
/**
 * Allows to inspect input and output of a command.
 *
 * @author Francesco Levorato <git@flevour.net>
 */
class ConsoleEvent extends \ConfigTransformer2021120210\Symfony\Contracts\EventDispatcher\Event
{
    protected $command;
    /**
     * @var \Symfony\Component\Console\Input\InputInterface
     */
    private $input;
    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    private $output;
    public function __construct(?\ConfigTransformer2021120210\Symfony\Component\Console\Command\Command $command, \ConfigTransformer2021120210\Symfony\Component\Console\Input\InputInterface $input, \ConfigTransformer2021120210\Symfony\Component\Console\Output\OutputInterface $output)
    {
        $this->command = $command;
        $this->input = $input;
        $this->output = $output;
    }
    /**
     * Gets the command that is executed.
     */
    public function getCommand() : ?\ConfigTransformer2021120210\Symfony\Component\Console\Command\Command
    {
        return $this->command;
    }
    /**
     * Gets the input instance.
     */
    public function getInput() : \ConfigTransformer2021120210\Symfony\Component\Console\Input\InputInterface
    {
        return $this->input;
    }
    /**
     * Gets the output instance.
     */
    public function getOutput() : \ConfigTransformer2021120210\Symfony\Component\Console\Output\OutputInterface
    {
        return $this->output;
    }
}
