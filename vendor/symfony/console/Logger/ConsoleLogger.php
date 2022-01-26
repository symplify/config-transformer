<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2022012610\Symfony\Component\Console\Logger;

use ConfigTransformer2022012610\Psr\Log\AbstractLogger;
use ConfigTransformer2022012610\Psr\Log\InvalidArgumentException;
use ConfigTransformer2022012610\Psr\Log\LogLevel;
use ConfigTransformer2022012610\Symfony\Component\Console\Output\ConsoleOutputInterface;
use ConfigTransformer2022012610\Symfony\Component\Console\Output\OutputInterface;
/**
 * PSR-3 compliant console logger.
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 *
 * @see https://www.php-fig.org/psr/psr-3/
 */
class ConsoleLogger extends \ConfigTransformer2022012610\Psr\Log\AbstractLogger
{
    public const INFO = 'info';
    public const ERROR = 'error';
    private $output;
    /**
     * @var mixed[]
     */
    private $verbosityLevelMap = [\ConfigTransformer2022012610\Psr\Log\LogLevel::EMERGENCY => \ConfigTransformer2022012610\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \ConfigTransformer2022012610\Psr\Log\LogLevel::ALERT => \ConfigTransformer2022012610\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \ConfigTransformer2022012610\Psr\Log\LogLevel::CRITICAL => \ConfigTransformer2022012610\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \ConfigTransformer2022012610\Psr\Log\LogLevel::ERROR => \ConfigTransformer2022012610\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \ConfigTransformer2022012610\Psr\Log\LogLevel::WARNING => \ConfigTransformer2022012610\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_NORMAL, \ConfigTransformer2022012610\Psr\Log\LogLevel::NOTICE => \ConfigTransformer2022012610\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERBOSE, \ConfigTransformer2022012610\Psr\Log\LogLevel::INFO => \ConfigTransformer2022012610\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERY_VERBOSE, \ConfigTransformer2022012610\Psr\Log\LogLevel::DEBUG => \ConfigTransformer2022012610\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG];
    /**
     * @var mixed[]
     */
    private $formatLevelMap = [\ConfigTransformer2022012610\Psr\Log\LogLevel::EMERGENCY => self::ERROR, \ConfigTransformer2022012610\Psr\Log\LogLevel::ALERT => self::ERROR, \ConfigTransformer2022012610\Psr\Log\LogLevel::CRITICAL => self::ERROR, \ConfigTransformer2022012610\Psr\Log\LogLevel::ERROR => self::ERROR, \ConfigTransformer2022012610\Psr\Log\LogLevel::WARNING => self::INFO, \ConfigTransformer2022012610\Psr\Log\LogLevel::NOTICE => self::INFO, \ConfigTransformer2022012610\Psr\Log\LogLevel::INFO => self::INFO, \ConfigTransformer2022012610\Psr\Log\LogLevel::DEBUG => self::INFO];
    /**
     * @var bool
     */
    private $errored = \false;
    public function __construct(\ConfigTransformer2022012610\Symfony\Component\Console\Output\OutputInterface $output, array $verbosityLevelMap = [], array $formatLevelMap = [])
    {
        $this->output = $output;
        $this->verbosityLevelMap = $verbosityLevelMap + $this->verbosityLevelMap;
        $this->formatLevelMap = $formatLevelMap + $this->formatLevelMap;
    }
    /**
     * {@inheritdoc}
     */
    public function log($level, $message, array $context = []) : void
    {
        if (!isset($this->verbosityLevelMap[$level])) {
            throw new \ConfigTransformer2022012610\Psr\Log\InvalidArgumentException(\sprintf('The log level "%s" does not exist.', $level));
        }
        $output = $this->output;
        // Write to the error output if necessary and available
        if (self::ERROR === $this->formatLevelMap[$level]) {
            if ($this->output instanceof \ConfigTransformer2022012610\Symfony\Component\Console\Output\ConsoleOutputInterface) {
                $output = $output->getErrorOutput();
            }
            $this->errored = \true;
        }
        // the if condition check isn't necessary -- it's the same one that $output will do internally anyway.
        // We only do it for efficiency here as the message formatting is relatively expensive.
        if ($output->getVerbosity() >= $this->verbosityLevelMap[$level]) {
            $output->writeln(\sprintf('<%1$s>[%2$s] %3$s</%1$s>', $this->formatLevelMap[$level], $level, $this->interpolate($message, $context)), $this->verbosityLevelMap[$level]);
        }
    }
    /**
     * Returns true when any messages have been logged at error levels.
     */
    public function hasErrored() : bool
    {
        return $this->errored;
    }
    /**
     * Interpolates context values into the message placeholders.
     *
     * @author PHP Framework Interoperability Group
     */
    private function interpolate(string $message, array $context) : string
    {
        if (\strpos($message, '{') === \false) {
            return $message;
        }
        $replacements = [];
        foreach ($context as $key => $val) {
            if (null === $val || \is_scalar($val) || $val instanceof \Stringable) {
                $replacements["{{$key}}"] = $val;
            } elseif ($val instanceof \DateTimeInterface) {
                $replacements["{{$key}}"] = $val->format(\DateTime::RFC3339);
            } elseif (\is_object($val)) {
                $replacements["{{$key}}"] = '[object ' . \get_class($val) . ']';
            } else {
                $replacements["{{$key}}"] = '[' . \gettype($val) . ']';
            }
        }
        return \strtr($message, $replacements);
    }
}
