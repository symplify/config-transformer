<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202205038\Symfony\Component\Console\EventListener;

use ConfigTransformer202205038\Psr\Log\LoggerInterface;
use ConfigTransformer202205038\Symfony\Component\Console\ConsoleEvents;
use ConfigTransformer202205038\Symfony\Component\Console\Event\ConsoleErrorEvent;
use ConfigTransformer202205038\Symfony\Component\Console\Event\ConsoleEvent;
use ConfigTransformer202205038\Symfony\Component\Console\Event\ConsoleTerminateEvent;
use ConfigTransformer202205038\Symfony\Component\EventDispatcher\EventSubscriberInterface;
/**
 * @author James Halsall <james.t.halsall@googlemail.com>
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class ErrorListener implements \ConfigTransformer202205038\Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    private $logger;
    public function __construct(\ConfigTransformer202205038\Psr\Log\LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }
    public function onConsoleError(\ConfigTransformer202205038\Symfony\Component\Console\Event\ConsoleErrorEvent $event)
    {
        if (null === $this->logger) {
            return;
        }
        $error = $event->getError();
        if (!($inputString = $this->getInputString($event))) {
            $this->logger->critical('An error occurred while using the console. Message: "{message}"', ['exception' => $error, 'message' => $error->getMessage()]);
            return;
        }
        $this->logger->critical('Error thrown while running command "{command}". Message: "{message}"', ['exception' => $error, 'command' => $inputString, 'message' => $error->getMessage()]);
    }
    public function onConsoleTerminate(\ConfigTransformer202205038\Symfony\Component\Console\Event\ConsoleTerminateEvent $event)
    {
        if (null === $this->logger) {
            return;
        }
        $exitCode = $event->getExitCode();
        if (0 === $exitCode) {
            return;
        }
        if (!($inputString = $this->getInputString($event))) {
            $this->logger->debug('The console exited with code "{code}"', ['code' => $exitCode]);
            return;
        }
        $this->logger->debug('Command "{command}" exited with code "{code}"', ['command' => $inputString, 'code' => $exitCode]);
    }
    public static function getSubscribedEvents() : array
    {
        return [\ConfigTransformer202205038\Symfony\Component\Console\ConsoleEvents::ERROR => ['onConsoleError', -128], \ConfigTransformer202205038\Symfony\Component\Console\ConsoleEvents::TERMINATE => ['onConsoleTerminate', -128]];
    }
    private static function getInputString(\ConfigTransformer202205038\Symfony\Component\Console\Event\ConsoleEvent $event) : ?string
    {
        $commandName = $event->getCommand() ? $event->getCommand()->getName() : null;
        $input = $event->getInput();
        if ($input instanceof \Stringable) {
            if ($commandName) {
                return \str_replace(["'{$commandName}'", "\"{$commandName}\""], $commandName, (string) $input);
            }
            return (string) $input;
        }
        return $commandName;
    }
}
