<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2021070510\Symfony\Component\Console;

use ConfigTransformer2021070510\Symfony\Component\Console\Command\Command;
use ConfigTransformer2021070510\Symfony\Component\Console\Command\HelpCommand;
use ConfigTransformer2021070510\Symfony\Component\Console\Command\LazyCommand;
use ConfigTransformer2021070510\Symfony\Component\Console\Command\ListCommand;
use ConfigTransformer2021070510\Symfony\Component\Console\Command\SignalableCommandInterface;
use ConfigTransformer2021070510\Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use ConfigTransformer2021070510\Symfony\Component\Console\Event\ConsoleCommandEvent;
use ConfigTransformer2021070510\Symfony\Component\Console\Event\ConsoleErrorEvent;
use ConfigTransformer2021070510\Symfony\Component\Console\Event\ConsoleSignalEvent;
use ConfigTransformer2021070510\Symfony\Component\Console\Event\ConsoleTerminateEvent;
use ConfigTransformer2021070510\Symfony\Component\Console\Exception\CommandNotFoundException;
use ConfigTransformer2021070510\Symfony\Component\Console\Exception\ExceptionInterface;
use ConfigTransformer2021070510\Symfony\Component\Console\Exception\LogicException;
use ConfigTransformer2021070510\Symfony\Component\Console\Exception\NamespaceNotFoundException;
use ConfigTransformer2021070510\Symfony\Component\Console\Exception\RuntimeException;
use ConfigTransformer2021070510\Symfony\Component\Console\Formatter\OutputFormatter;
use ConfigTransformer2021070510\Symfony\Component\Console\Helper\DebugFormatterHelper;
use ConfigTransformer2021070510\Symfony\Component\Console\Helper\FormatterHelper;
use ConfigTransformer2021070510\Symfony\Component\Console\Helper\Helper;
use ConfigTransformer2021070510\Symfony\Component\Console\Helper\HelperSet;
use ConfigTransformer2021070510\Symfony\Component\Console\Helper\ProcessHelper;
use ConfigTransformer2021070510\Symfony\Component\Console\Helper\QuestionHelper;
use ConfigTransformer2021070510\Symfony\Component\Console\Input\ArgvInput;
use ConfigTransformer2021070510\Symfony\Component\Console\Input\ArrayInput;
use ConfigTransformer2021070510\Symfony\Component\Console\Input\InputArgument;
use ConfigTransformer2021070510\Symfony\Component\Console\Input\InputAwareInterface;
use ConfigTransformer2021070510\Symfony\Component\Console\Input\InputDefinition;
use ConfigTransformer2021070510\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer2021070510\Symfony\Component\Console\Input\InputOption;
use ConfigTransformer2021070510\Symfony\Component\Console\Output\ConsoleOutput;
use ConfigTransformer2021070510\Symfony\Component\Console\Output\ConsoleOutputInterface;
use ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface;
use ConfigTransformer2021070510\Symfony\Component\Console\SignalRegistry\SignalRegistry;
use ConfigTransformer2021070510\Symfony\Component\Console\Style\SymfonyStyle;
use ConfigTransformer2021070510\Symfony\Component\ErrorHandler\ErrorHandler;
use ConfigTransformer2021070510\Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ConfigTransformer2021070510\Symfony\Contracts\Service\ResetInterface;
/**
 * An Application is the container for a collection of commands.
 *
 * It is the main entry point of a Console application.
 *
 * This class is optimized for a standard CLI environment.
 *
 * Usage:
 *
 *     $app = new Application('myapp', '1.0 (stable)');
 *     $app->add(new SimpleCommand());
 *     $app->run();
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Application implements \ConfigTransformer2021070510\Symfony\Contracts\Service\ResetInterface
{
    private $commands = [];
    private $wantHelps = \false;
    private $runningCommand;
    private $name;
    private $version;
    private $commandLoader;
    private $catchExceptions = \true;
    private $autoExit = \true;
    private $definition;
    private $helperSet;
    private $dispatcher;
    private $terminal;
    private $defaultCommand;
    private $singleCommand = \false;
    private $initialized;
    private $signalRegistry;
    private $signalsToDispatchEvent = [];
    public function __construct(string $name = 'UNKNOWN', string $version = 'UNKNOWN')
    {
        $this->name = $name;
        $this->version = $version;
        $this->terminal = new \ConfigTransformer2021070510\Symfony\Component\Console\Terminal();
        $this->defaultCommand = 'list';
        if (\defined('SIGINT') && \ConfigTransformer2021070510\Symfony\Component\Console\SignalRegistry\SignalRegistry::isSupported()) {
            $this->signalRegistry = new \ConfigTransformer2021070510\Symfony\Component\Console\SignalRegistry\SignalRegistry();
            $this->signalsToDispatchEvent = [\SIGINT, \SIGTERM, \SIGUSR1, \SIGUSR2];
        }
    }
    /**
     * @final
     */
    public function setDispatcher(\ConfigTransformer2021070510\Symfony\Contracts\EventDispatcher\EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
    public function setCommandLoader(\ConfigTransformer2021070510\Symfony\Component\Console\CommandLoader\CommandLoaderInterface $commandLoader)
    {
        $this->commandLoader = $commandLoader;
    }
    public function getSignalRegistry() : \ConfigTransformer2021070510\Symfony\Component\Console\SignalRegistry\SignalRegistry
    {
        if (!$this->signalRegistry) {
            throw new \ConfigTransformer2021070510\Symfony\Component\Console\Exception\RuntimeException('Signals are not supported. Make sure that the `pcntl` extension is installed and that "pcntl_*" functions are not disabled by your php.ini\'s "disable_functions" directive.');
        }
        return $this->signalRegistry;
    }
    public function setSignalsToDispatchEvent(int ...$signalsToDispatchEvent)
    {
        $this->signalsToDispatchEvent = $signalsToDispatchEvent;
    }
    /**
     * Runs the current application.
     *
     * @return int 0 if everything went fine, or an error code
     *
     * @throws \Exception When running fails. Bypass this when {@link setCatchExceptions()}.
     */
    public function run(\ConfigTransformer2021070510\Symfony\Component\Console\Input\InputInterface $input = null, \ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface $output = null)
    {
        if (\function_exists('putenv')) {
            @\putenv('LINES=' . $this->terminal->getHeight());
            @\putenv('COLUMNS=' . $this->terminal->getWidth());
        }
        if (null === $input) {
            $input = new \ConfigTransformer2021070510\Symfony\Component\Console\Input\ArgvInput();
        }
        if (null === $output) {
            $output = new \ConfigTransformer2021070510\Symfony\Component\Console\Output\ConsoleOutput();
        }
        $renderException = function (\Throwable $e) use($output) {
            if ($output instanceof \ConfigTransformer2021070510\Symfony\Component\Console\Output\ConsoleOutputInterface) {
                $this->renderThrowable($e, $output->getErrorOutput());
            } else {
                $this->renderThrowable($e, $output);
            }
        };
        if ($phpHandler = \set_exception_handler($renderException)) {
            \restore_exception_handler();
            if (!\is_array($phpHandler) || !$phpHandler[0] instanceof \ConfigTransformer2021070510\Symfony\Component\ErrorHandler\ErrorHandler) {
                $errorHandler = \true;
            } elseif ($errorHandler = $phpHandler[0]->setExceptionHandler($renderException)) {
                $phpHandler[0]->setExceptionHandler($errorHandler);
            }
        }
        $this->configureIO($input, $output);
        try {
            $exitCode = $this->doRun($input, $output);
        } catch (\Exception $e) {
            if (!$this->catchExceptions) {
                throw $e;
            }
            $renderException($e);
            $exitCode = $e->getCode();
            if (\is_numeric($exitCode)) {
                $exitCode = (int) $exitCode;
                if (0 === $exitCode) {
                    $exitCode = 1;
                }
            } else {
                $exitCode = 1;
            }
        } finally {
            // if the exception handler changed, keep it
            // otherwise, unregister $renderException
            if (!$phpHandler) {
                if (\set_exception_handler($renderException) === $renderException) {
                    \restore_exception_handler();
                }
                \restore_exception_handler();
            } elseif (!$errorHandler) {
                $finalHandler = $phpHandler[0]->setExceptionHandler(null);
                if ($finalHandler !== $renderException) {
                    $phpHandler[0]->setExceptionHandler($finalHandler);
                }
            }
        }
        if ($this->autoExit) {
            if ($exitCode > 255) {
                $exitCode = 255;
            }
            exit($exitCode);
        }
        return $exitCode;
    }
    /**
     * Runs the current application.
     *
     * @return int 0 if everything went fine, or an error code
     */
    public function doRun(\ConfigTransformer2021070510\Symfony\Component\Console\Input\InputInterface $input, \ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface $output)
    {
        if (\true === $input->hasParameterOption(['--version', '-V'], \true)) {
            $output->writeln($this->getLongVersion());
            return 0;
        }
        try {
            // Makes ArgvInput::getFirstArgument() able to distinguish an option from an argument.
            $input->bind($this->getDefinition());
        } catch (\ConfigTransformer2021070510\Symfony\Component\Console\Exception\ExceptionInterface $e) {
            // Errors must be ignored, full binding/validation happens later when the command is known.
        }
        $name = $this->getCommandName($input);
        if (\true === $input->hasParameterOption(['--help', '-h'], \true)) {
            if (!$name) {
                $name = 'help';
                $input = new \ConfigTransformer2021070510\Symfony\Component\Console\Input\ArrayInput(['command_name' => $this->defaultCommand]);
            } else {
                $this->wantHelps = \true;
            }
        }
        if (!$name) {
            $name = $this->defaultCommand;
            $definition = $this->getDefinition();
            $definition->setArguments(\array_merge($definition->getArguments(), ['command' => new \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputArgument('command', \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputArgument::OPTIONAL, $definition->getArgument('command')->getDescription(), $name)]));
        }
        try {
            $this->runningCommand = null;
            // the command name MUST be the first element of the input
            $command = $this->find($name);
        } catch (\Throwable $e) {
            if (!($e instanceof \ConfigTransformer2021070510\Symfony\Component\Console\Exception\CommandNotFoundException && !$e instanceof \ConfigTransformer2021070510\Symfony\Component\Console\Exception\NamespaceNotFoundException) || 1 !== \count($alternatives = $e->getAlternatives()) || !$input->isInteractive()) {
                if (null !== $this->dispatcher) {
                    $event = new \ConfigTransformer2021070510\Symfony\Component\Console\Event\ConsoleErrorEvent($input, $output, $e);
                    $this->dispatcher->dispatch($event, \ConfigTransformer2021070510\Symfony\Component\Console\ConsoleEvents::ERROR);
                    if (0 === $event->getExitCode()) {
                        return 0;
                    }
                    $e = $event->getError();
                }
                throw $e;
            }
            $alternative = $alternatives[0];
            $style = new \ConfigTransformer2021070510\Symfony\Component\Console\Style\SymfonyStyle($input, $output);
            $style->block(\sprintf("\nCommand \"%s\" is not defined.\n", $name), null, 'error');
            if (!$style->confirm(\sprintf('Do you want to run "%s" instead? ', $alternative), \false)) {
                if (null !== $this->dispatcher) {
                    $event = new \ConfigTransformer2021070510\Symfony\Component\Console\Event\ConsoleErrorEvent($input, $output, $e);
                    $this->dispatcher->dispatch($event, \ConfigTransformer2021070510\Symfony\Component\Console\ConsoleEvents::ERROR);
                    return $event->getExitCode();
                }
                return 1;
            }
            $command = $this->find($alternative);
        }
        if ($command instanceof \ConfigTransformer2021070510\Symfony\Component\Console\Command\LazyCommand) {
            $command = $command->getCommand();
        }
        $this->runningCommand = $command;
        $exitCode = $this->doRunCommand($command, $input, $output);
        $this->runningCommand = null;
        return $exitCode;
    }
    /**
     * {@inheritdoc}
     */
    public function reset()
    {
    }
    public function setHelperSet(\ConfigTransformer2021070510\Symfony\Component\Console\Helper\HelperSet $helperSet)
    {
        $this->helperSet = $helperSet;
    }
    /**
     * Get the helper set associated with the command.
     *
     * @return HelperSet The HelperSet instance associated with this command
     */
    public function getHelperSet()
    {
        if (!$this->helperSet) {
            $this->helperSet = $this->getDefaultHelperSet();
        }
        return $this->helperSet;
    }
    public function setDefinition(\ConfigTransformer2021070510\Symfony\Component\Console\Input\InputDefinition $definition)
    {
        $this->definition = $definition;
    }
    /**
     * Gets the InputDefinition related to this Application.
     *
     * @return InputDefinition The InputDefinition instance
     */
    public function getDefinition()
    {
        if (!$this->definition) {
            $this->definition = $this->getDefaultInputDefinition();
        }
        if ($this->singleCommand) {
            $inputDefinition = $this->definition;
            $inputDefinition->setArguments();
            return $inputDefinition;
        }
        return $this->definition;
    }
    /**
     * Gets the help message.
     *
     * @return string A help message
     */
    public function getHelp()
    {
        return $this->getLongVersion();
    }
    /**
     * Gets whether to catch exceptions or not during commands execution.
     *
     * @return bool Whether to catch exceptions or not during commands execution
     */
    public function areExceptionsCaught()
    {
        return $this->catchExceptions;
    }
    /**
     * Sets whether to catch exceptions or not during commands execution.
     */
    public function setCatchExceptions(bool $boolean)
    {
        $this->catchExceptions = $boolean;
    }
    /**
     * Gets whether to automatically exit after a command execution or not.
     *
     * @return bool Whether to automatically exit after a command execution or not
     */
    public function isAutoExitEnabled()
    {
        return $this->autoExit;
    }
    /**
     * Sets whether to automatically exit after a command execution or not.
     */
    public function setAutoExit(bool $boolean)
    {
        $this->autoExit = $boolean;
    }
    /**
     * Gets the name of the application.
     *
     * @return string The application name
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Sets the application name.
     **/
    public function setName(string $name)
    {
        $this->name = $name;
    }
    /**
     * Gets the application version.
     *
     * @return string The application version
     */
    public function getVersion()
    {
        return $this->version;
    }
    /**
     * Sets the application version.
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }
    /**
     * Returns the long version of the application.
     *
     * @return string The long application version
     */
    public function getLongVersion()
    {
        if ('UNKNOWN' !== $this->getName()) {
            if ('UNKNOWN' !== $this->getVersion()) {
                return \sprintf('%s <info>%s</info>', $this->getName(), $this->getVersion());
            }
            return $this->getName();
        }
        return 'Console Tool';
    }
    /**
     * Registers a new command.
     *
     * @return Command The newly created command
     */
    public function register(string $name)
    {
        return $this->add(new \ConfigTransformer2021070510\Symfony\Component\Console\Command\Command($name));
    }
    /**
     * Adds an array of command objects.
     *
     * If a Command is not enabled it will not be added.
     *
     * @param Command[] $commands An array of commands
     */
    public function addCommands(array $commands)
    {
        foreach ($commands as $command) {
            $this->add($command);
        }
    }
    /**
     * Adds a command object.
     *
     * If a command with the same name already exists, it will be overridden.
     * If the command is not enabled it will not be added.
     *
     * @return Command|null The registered command if enabled or null
     */
    public function add(\ConfigTransformer2021070510\Symfony\Component\Console\Command\Command $command)
    {
        $this->init();
        $command->setApplication($this);
        if (!$command->isEnabled()) {
            $command->setApplication(null);
            return null;
        }
        if (!$command instanceof \ConfigTransformer2021070510\Symfony\Component\Console\Command\LazyCommand) {
            // Will throw if the command is not correctly initialized.
            $command->getDefinition();
        }
        if (!$command->getName()) {
            throw new \ConfigTransformer2021070510\Symfony\Component\Console\Exception\LogicException(\sprintf('The command defined in "%s" cannot have an empty name.', \get_debug_type($command)));
        }
        $this->commands[$command->getName()] = $command;
        foreach ($command->getAliases() as $alias) {
            $this->commands[$alias] = $command;
        }
        return $command;
    }
    /**
     * Returns a registered command by name or alias.
     *
     * @return Command A Command object
     *
     * @throws CommandNotFoundException When given command name does not exist
     */
    public function get(string $name)
    {
        $this->init();
        if (!$this->has($name)) {
            throw new \ConfigTransformer2021070510\Symfony\Component\Console\Exception\CommandNotFoundException(\sprintf('The command "%s" does not exist.', $name));
        }
        // When the command has a different name than the one used at the command loader level
        if (!isset($this->commands[$name])) {
            throw new \ConfigTransformer2021070510\Symfony\Component\Console\Exception\CommandNotFoundException(\sprintf('The "%s" command cannot be found because it is registered under multiple names. Make sure you don\'t set a different name via constructor or "setName()".', $name));
        }
        $command = $this->commands[$name];
        if ($this->wantHelps) {
            $this->wantHelps = \false;
            $helpCommand = $this->get('help');
            $helpCommand->setCommand($command);
            return $helpCommand;
        }
        return $command;
    }
    /**
     * Returns true if the command exists, false otherwise.
     *
     * @return bool true if the command exists, false otherwise
     */
    public function has(string $name)
    {
        $this->init();
        return isset($this->commands[$name]) || $this->commandLoader && $this->commandLoader->has($name) && $this->add($this->commandLoader->get($name));
    }
    /**
     * Returns an array of all unique namespaces used by currently registered commands.
     *
     * It does not return the global namespace which always exists.
     *
     * @return string[] An array of namespaces
     */
    public function getNamespaces()
    {
        $namespaces = [];
        foreach ($this->all() as $command) {
            if ($command->isHidden()) {
                continue;
            }
            $namespaces = \array_merge($namespaces, $this->extractAllNamespaces($command->getName()));
            foreach ($command->getAliases() as $alias) {
                $namespaces = \array_merge($namespaces, $this->extractAllNamespaces($alias));
            }
        }
        return \array_values(\array_unique(\array_filter($namespaces)));
    }
    /**
     * Finds a registered namespace by a name or an abbreviation.
     *
     * @return string A registered namespace
     *
     * @throws NamespaceNotFoundException When namespace is incorrect or ambiguous
     */
    public function findNamespace(string $namespace)
    {
        $allNamespaces = $this->getNamespaces();
        $expr = \implode('[^:]*:', \array_map('preg_quote', \explode(':', $namespace))) . '[^:]*';
        $namespaces = \preg_grep('{^' . $expr . '}', $allNamespaces);
        if (empty($namespaces)) {
            $message = \sprintf('There are no commands defined in the "%s" namespace.', $namespace);
            if ($alternatives = $this->findAlternatives($namespace, $allNamespaces)) {
                if (1 == \count($alternatives)) {
                    $message .= "\n\nDid you mean this?\n    ";
                } else {
                    $message .= "\n\nDid you mean one of these?\n    ";
                }
                $message .= \implode("\n    ", $alternatives);
            }
            throw new \ConfigTransformer2021070510\Symfony\Component\Console\Exception\NamespaceNotFoundException($message, $alternatives);
        }
        $exact = \in_array($namespace, $namespaces, \true);
        if (\count($namespaces) > 1 && !$exact) {
            throw new \ConfigTransformer2021070510\Symfony\Component\Console\Exception\NamespaceNotFoundException(\sprintf("The namespace \"%s\" is ambiguous.\nDid you mean one of these?\n%s.", $namespace, $this->getAbbreviationSuggestions(\array_values($namespaces))), \array_values($namespaces));
        }
        return $exact ? $namespace : \reset($namespaces);
    }
    /**
     * Finds a command by name or alias.
     *
     * Contrary to get, this command tries to find the best
     * match if you give it an abbreviation of a name or alias.
     *
     * @return Command A Command instance
     *
     * @throws CommandNotFoundException When command name is incorrect or ambiguous
     */
    public function find(string $name)
    {
        $this->init();
        $aliases = [];
        foreach ($this->commands as $command) {
            foreach ($command->getAliases() as $alias) {
                if (!$this->has($alias)) {
                    $this->commands[$alias] = $command;
                }
            }
        }
        if ($this->has($name)) {
            return $this->get($name);
        }
        $allCommands = $this->commandLoader ? \array_merge($this->commandLoader->getNames(), \array_keys($this->commands)) : \array_keys($this->commands);
        $expr = \implode('[^:]*:', \array_map('preg_quote', \explode(':', $name))) . '[^:]*';
        $commands = \preg_grep('{^' . $expr . '}', $allCommands);
        if (empty($commands)) {
            $commands = \preg_grep('{^' . $expr . '}i', $allCommands);
        }
        // if no commands matched or we just matched namespaces
        if (empty($commands) || \count(\preg_grep('{^' . $expr . '$}i', $commands)) < 1) {
            if (\false !== ($pos = \strrpos($name, ':'))) {
                // check if a namespace exists and contains commands
                $this->findNamespace(\substr($name, 0, $pos));
            }
            $message = \sprintf('Command "%s" is not defined.', $name);
            if ($alternatives = $this->findAlternatives($name, $allCommands)) {
                // remove hidden commands
                $alternatives = \array_filter($alternatives, function ($name) {
                    return !$this->get($name)->isHidden();
                });
                if (1 == \count($alternatives)) {
                    $message .= "\n\nDid you mean this?\n    ";
                } else {
                    $message .= "\n\nDid you mean one of these?\n    ";
                }
                $message .= \implode("\n    ", $alternatives);
            }
            throw new \ConfigTransformer2021070510\Symfony\Component\Console\Exception\CommandNotFoundException($message, \array_values($alternatives));
        }
        // filter out aliases for commands which are already on the list
        if (\count($commands) > 1) {
            $commandList = $this->commandLoader ? \array_merge(\array_flip($this->commandLoader->getNames()), $this->commands) : $this->commands;
            $commands = \array_unique(\array_filter($commands, function ($nameOrAlias) use(&$commandList, $commands, &$aliases) {
                if (!$commandList[$nameOrAlias] instanceof \ConfigTransformer2021070510\Symfony\Component\Console\Command\Command) {
                    $commandList[$nameOrAlias] = $this->commandLoader->get($nameOrAlias);
                }
                $commandName = $commandList[$nameOrAlias]->getName();
                $aliases[$nameOrAlias] = $commandName;
                return $commandName === $nameOrAlias || !\in_array($commandName, $commands);
            }));
        }
        if (\count($commands) > 1) {
            $usableWidth = $this->terminal->getWidth() - 10;
            $abbrevs = \array_values($commands);
            $maxLen = 0;
            foreach ($abbrevs as $abbrev) {
                $maxLen = \max(\ConfigTransformer2021070510\Symfony\Component\Console\Helper\Helper::width($abbrev), $maxLen);
            }
            $abbrevs = \array_map(function ($cmd) use($commandList, $usableWidth, $maxLen, &$commands) {
                if ($commandList[$cmd]->isHidden()) {
                    unset($commands[\array_search($cmd, $commands)]);
                    return \false;
                }
                $abbrev = \str_pad($cmd, $maxLen, ' ') . ' ' . $commandList[$cmd]->getDescription();
                return \ConfigTransformer2021070510\Symfony\Component\Console\Helper\Helper::width($abbrev) > $usableWidth ? \ConfigTransformer2021070510\Symfony\Component\Console\Helper\Helper::substr($abbrev, 0, $usableWidth - 3) . '...' : $abbrev;
            }, \array_values($commands));
            if (\count($commands) > 1) {
                $suggestions = $this->getAbbreviationSuggestions(\array_filter($abbrevs));
                throw new \ConfigTransformer2021070510\Symfony\Component\Console\Exception\CommandNotFoundException(\sprintf("Command \"%s\" is ambiguous.\nDid you mean one of these?\n%s.", $name, $suggestions), \array_values($commands));
            }
        }
        $command = $this->get(\reset($commands));
        if ($command->isHidden()) {
            throw new \ConfigTransformer2021070510\Symfony\Component\Console\Exception\CommandNotFoundException(\sprintf('The command "%s" does not exist.', $name));
        }
        return $command;
    }
    /**
     * Gets the commands (registered in the given namespace if provided).
     *
     * The array keys are the full names and the values the command instances.
     *
     * @return Command[] An array of Command instances
     */
    public function all(string $namespace = null)
    {
        $this->init();
        if (null === $namespace) {
            if (!$this->commandLoader) {
                return $this->commands;
            }
            $commands = $this->commands;
            foreach ($this->commandLoader->getNames() as $name) {
                if (!isset($commands[$name]) && $this->has($name)) {
                    $commands[$name] = $this->get($name);
                }
            }
            return $commands;
        }
        $commands = [];
        foreach ($this->commands as $name => $command) {
            if ($namespace === $this->extractNamespace($name, \substr_count($namespace, ':') + 1)) {
                $commands[$name] = $command;
            }
        }
        if ($this->commandLoader) {
            foreach ($this->commandLoader->getNames() as $name) {
                if (!isset($commands[$name]) && $namespace === $this->extractNamespace($name, \substr_count($namespace, ':') + 1) && $this->has($name)) {
                    $commands[$name] = $this->get($name);
                }
            }
        }
        return $commands;
    }
    /**
     * Returns an array of possible abbreviations given a set of names.
     *
     * @return string[][] An array of abbreviations
     */
    public static function getAbbreviations(array $names)
    {
        $abbrevs = [];
        foreach ($names as $name) {
            for ($len = \strlen($name); $len > 0; --$len) {
                $abbrev = \substr($name, 0, $len);
                $abbrevs[$abbrev][] = $name;
            }
        }
        return $abbrevs;
    }
    public function renderThrowable(\Throwable $e, \ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface $output) : void
    {
        $output->writeln('', \ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET);
        $this->doRenderThrowable($e, $output);
        if (null !== $this->runningCommand) {
            $output->writeln(\sprintf('<info>%s</info>', \ConfigTransformer2021070510\Symfony\Component\Console\Formatter\OutputFormatter::escape(\sprintf($this->runningCommand->getSynopsis(), $this->getName()))), \ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET);
            $output->writeln('', \ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET);
        }
    }
    protected function doRenderThrowable(\Throwable $e, \ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface $output) : void
    {
        do {
            $message = \trim($e->getMessage());
            if ('' === $message || \ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity()) {
                $class = \get_debug_type($e);
                $title = \sprintf('  [%s%s]  ', $class, 0 !== ($code = $e->getCode()) ? ' (' . $code . ')' : '');
                $len = \ConfigTransformer2021070510\Symfony\Component\Console\Helper\Helper::width($title);
            } else {
                $len = 0;
            }
            if (\false !== \strpos($message, "@anonymous\0")) {
                $message = \preg_replace_callback('/[a-zA-Z_\\x7f-\\xff][\\\\a-zA-Z0-9_\\x7f-\\xff]*+@anonymous\\x00.*?\\.php(?:0x?|:[0-9]++\\$)[0-9a-fA-F]++/', function ($m) {
                    return \class_exists($m[0], \false) ? ((\get_parent_class($m[0]) ?: \key(\class_implements($m[0]))) ?: 'class') . '@anonymous' : $m[0];
                }, $message);
            }
            $width = $this->terminal->getWidth() ? $this->terminal->getWidth() - 1 : \PHP_INT_MAX;
            $lines = [];
            foreach ('' !== $message ? \preg_split('/\\r?\\n/', $message) : [] as $line) {
                foreach ($this->splitStringByWidth($line, $width - 4) as $line) {
                    // pre-format lines to get the right string length
                    $lineLength = \ConfigTransformer2021070510\Symfony\Component\Console\Helper\Helper::width($line) + 4;
                    $lines[] = [$line, $lineLength];
                    $len = \max($lineLength, $len);
                }
            }
            $messages = [];
            if (!$e instanceof \ConfigTransformer2021070510\Symfony\Component\Console\Exception\ExceptionInterface || \ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity()) {
                $messages[] = \sprintf('<comment>%s</comment>', \ConfigTransformer2021070510\Symfony\Component\Console\Formatter\OutputFormatter::escape(\sprintf('In %s line %s:', \basename($e->getFile()) ?: 'n/a', $e->getLine() ?: 'n/a')));
            }
            $messages[] = $emptyLine = \sprintf('<error>%s</error>', \str_repeat(' ', $len));
            if ('' === $message || \ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity()) {
                $messages[] = \sprintf('<error>%s%s</error>', $title, \str_repeat(' ', \max(0, $len - \ConfigTransformer2021070510\Symfony\Component\Console\Helper\Helper::width($title))));
            }
            foreach ($lines as $line) {
                $messages[] = \sprintf('<error>  %s  %s</error>', \ConfigTransformer2021070510\Symfony\Component\Console\Formatter\OutputFormatter::escape($line[0]), \str_repeat(' ', $len - $line[1]));
            }
            $messages[] = $emptyLine;
            $messages[] = '';
            $output->writeln($messages, \ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET);
            if (\ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERBOSE <= $output->getVerbosity()) {
                $output->writeln('<comment>Exception trace:</comment>', \ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET);
                // exception related properties
                $trace = $e->getTrace();
                \array_unshift($trace, ['function' => '', 'file' => $e->getFile() ?: 'n/a', 'line' => $e->getLine() ?: 'n/a', 'args' => []]);
                for ($i = 0, $count = \count($trace); $i < $count; ++$i) {
                    $class = $trace[$i]['class'] ?? '';
                    $type = $trace[$i]['type'] ?? '';
                    $function = $trace[$i]['function'] ?? '';
                    $file = $trace[$i]['file'] ?? 'n/a';
                    $line = $trace[$i]['line'] ?? 'n/a';
                    $output->writeln(\sprintf(' %s%s at <info>%s:%s</info>', $class, $function ? $type . $function . '()' : '', $file, $line), \ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET);
                }
                $output->writeln('', \ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET);
            }
        } while ($e = $e->getPrevious());
    }
    /**
     * Configures the input and output instances based on the user arguments and options.
     */
    protected function configureIO(\ConfigTransformer2021070510\Symfony\Component\Console\Input\InputInterface $input, \ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface $output)
    {
        if (\true === $input->hasParameterOption(['--ansi'], \true)) {
            $output->setDecorated(\true);
        } elseif (\true === $input->hasParameterOption(['--no-ansi'], \true)) {
            $output->setDecorated(\false);
        }
        if (\true === $input->hasParameterOption(['--no-interaction', '-n'], \true)) {
            $input->setInteractive(\false);
        }
        switch ($shellVerbosity = (int) \getenv('SHELL_VERBOSITY')) {
            case -1:
                $output->setVerbosity(\ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET);
                break;
            case 1:
                $output->setVerbosity(\ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERBOSE);
                break;
            case 2:
                $output->setVerbosity(\ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERY_VERBOSE);
                break;
            case 3:
                $output->setVerbosity(\ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG);
                break;
            default:
                $shellVerbosity = 0;
                break;
        }
        if (\true === $input->hasParameterOption(['--quiet', '-q'], \true)) {
            $output->setVerbosity(\ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_QUIET);
            $shellVerbosity = -1;
        } else {
            if ($input->hasParameterOption('-vvv', \true) || $input->hasParameterOption('--verbose=3', \true) || 3 === $input->getParameterOption('--verbose', \false, \true)) {
                $output->setVerbosity(\ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_DEBUG);
                $shellVerbosity = 3;
            } elseif ($input->hasParameterOption('-vv', \true) || $input->hasParameterOption('--verbose=2', \true) || 2 === $input->getParameterOption('--verbose', \false, \true)) {
                $output->setVerbosity(\ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERY_VERBOSE);
                $shellVerbosity = 2;
            } elseif ($input->hasParameterOption('-v', \true) || $input->hasParameterOption('--verbose=1', \true) || $input->hasParameterOption('--verbose', \true) || $input->getParameterOption('--verbose', \false, \true)) {
                $output->setVerbosity(\ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface::VERBOSITY_VERBOSE);
                $shellVerbosity = 1;
            }
        }
        if (-1 === $shellVerbosity) {
            $input->setInteractive(\false);
        }
        if (\function_exists('putenv')) {
            @\putenv('SHELL_VERBOSITY=' . $shellVerbosity);
        }
        $_ENV['SHELL_VERBOSITY'] = $shellVerbosity;
        $_SERVER['SHELL_VERBOSITY'] = $shellVerbosity;
    }
    /**
     * Runs the current command.
     *
     * If an event dispatcher has been attached to the application,
     * events are also dispatched during the life-cycle of the command.
     *
     * @return int 0 if everything went fine, or an error code
     */
    protected function doRunCommand(\ConfigTransformer2021070510\Symfony\Component\Console\Command\Command $command, \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputInterface $input, \ConfigTransformer2021070510\Symfony\Component\Console\Output\OutputInterface $output)
    {
        foreach ($command->getHelperSet() as $helper) {
            if ($helper instanceof \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputAwareInterface) {
                $helper->setInput($input);
            }
        }
        if ($command instanceof \ConfigTransformer2021070510\Symfony\Component\Console\Command\SignalableCommandInterface) {
            if (!$this->signalRegistry) {
                throw new \ConfigTransformer2021070510\Symfony\Component\Console\Exception\RuntimeException('Unable to subscribe to signal events. Make sure that the `pcntl` extension is installed and that "pcntl_*" functions are not disabled by your php.ini\'s "disable_functions" directive.');
            }
            if ($this->dispatcher) {
                foreach ($this->signalsToDispatchEvent as $signal) {
                    $event = new \ConfigTransformer2021070510\Symfony\Component\Console\Event\ConsoleSignalEvent($command, $input, $output, $signal);
                    $this->signalRegistry->register($signal, function ($signal, $hasNext) use($event) {
                        $this->dispatcher->dispatch($event, \ConfigTransformer2021070510\Symfony\Component\Console\ConsoleEvents::SIGNAL);
                        // No more handlers, we try to simulate PHP default behavior
                        if (!$hasNext) {
                            if (!\in_array($signal, [\SIGUSR1, \SIGUSR2], \true)) {
                                exit(0);
                            }
                        }
                    });
                }
            }
            foreach ($command->getSubscribedSignals() as $signal) {
                $this->signalRegistry->register($signal, [$command, 'handleSignal']);
            }
        }
        if (null === $this->dispatcher) {
            return $command->run($input, $output);
        }
        // bind before the console.command event, so the listeners have access to input options/arguments
        try {
            $command->mergeApplicationDefinition();
            $input->bind($command->getDefinition());
        } catch (\ConfigTransformer2021070510\Symfony\Component\Console\Exception\ExceptionInterface $e) {
            // ignore invalid options/arguments for now, to allow the event listeners to customize the InputDefinition
        }
        $event = new \ConfigTransformer2021070510\Symfony\Component\Console\Event\ConsoleCommandEvent($command, $input, $output);
        $e = null;
        try {
            $this->dispatcher->dispatch($event, \ConfigTransformer2021070510\Symfony\Component\Console\ConsoleEvents::COMMAND);
            if ($event->commandShouldRun()) {
                $exitCode = $command->run($input, $output);
            } else {
                $exitCode = \ConfigTransformer2021070510\Symfony\Component\Console\Event\ConsoleCommandEvent::RETURN_CODE_DISABLED;
            }
        } catch (\Throwable $e) {
            $event = new \ConfigTransformer2021070510\Symfony\Component\Console\Event\ConsoleErrorEvent($input, $output, $e, $command);
            $this->dispatcher->dispatch($event, \ConfigTransformer2021070510\Symfony\Component\Console\ConsoleEvents::ERROR);
            $e = $event->getError();
            if (0 === ($exitCode = $event->getExitCode())) {
                $e = null;
            }
        }
        $event = new \ConfigTransformer2021070510\Symfony\Component\Console\Event\ConsoleTerminateEvent($command, $input, $output, $exitCode);
        $this->dispatcher->dispatch($event, \ConfigTransformer2021070510\Symfony\Component\Console\ConsoleEvents::TERMINATE);
        if (null !== $e) {
            throw $e;
        }
        return $event->getExitCode();
    }
    /**
     * Gets the name of the command based on input.
     *
     * @return string|null
     */
    protected function getCommandName(\ConfigTransformer2021070510\Symfony\Component\Console\Input\InputInterface $input)
    {
        return $this->singleCommand ? $this->defaultCommand : $input->getFirstArgument();
    }
    /**
     * Gets the default input definition.
     *
     * @return InputDefinition An InputDefinition instance
     */
    protected function getDefaultInputDefinition()
    {
        return new \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputDefinition([new \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputArgument('command', \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputArgument::REQUIRED, 'The command to execute'), new \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputOption('--help', '-h', \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Display help for the given command. When no command is given display help for the <info>' . $this->defaultCommand . '</info> command'), new \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputOption('--quiet', '-q', \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Do not output any message'), new \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputOption('--verbose', '-v|vv|vvv', \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug'), new \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputOption('--version', '-V', \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Display this application version'), new \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputOption('--ansi', '', \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputOption::VALUE_NEGATABLE, 'Force (or disable --no-ansi) ANSI output', \false), new \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputOption('--no-interaction', '-n', \ConfigTransformer2021070510\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'Do not ask any interactive question')]);
    }
    /**
     * Gets the default commands that should always be available.
     *
     * @return Command[] An array of default Command instances
     */
    protected function getDefaultCommands()
    {
        return [new \ConfigTransformer2021070510\Symfony\Component\Console\Command\HelpCommand(), new \ConfigTransformer2021070510\Symfony\Component\Console\Command\ListCommand()];
    }
    /**
     * Gets the default helper set with the helpers that should always be available.
     *
     * @return HelperSet A HelperSet instance
     */
    protected function getDefaultHelperSet()
    {
        return new \ConfigTransformer2021070510\Symfony\Component\Console\Helper\HelperSet([new \ConfigTransformer2021070510\Symfony\Component\Console\Helper\FormatterHelper(), new \ConfigTransformer2021070510\Symfony\Component\Console\Helper\DebugFormatterHelper(), new \ConfigTransformer2021070510\Symfony\Component\Console\Helper\ProcessHelper(), new \ConfigTransformer2021070510\Symfony\Component\Console\Helper\QuestionHelper()]);
    }
    /**
     * Returns abbreviated suggestions in string format.
     */
    private function getAbbreviationSuggestions(array $abbrevs) : string
    {
        return '    ' . \implode("\n    ", $abbrevs);
    }
    /**
     * Returns the namespace part of the command name.
     *
     * This method is not part of public API and should not be used directly.
     *
     * @return string The namespace of the command
     */
    public function extractNamespace(string $name, int $limit = null)
    {
        $parts = \explode(':', $name, -1);
        return \implode(':', null === $limit ? $parts : \array_slice($parts, 0, $limit));
    }
    /**
     * Finds alternative of $name among $collection,
     * if nothing is found in $collection, try in $abbrevs.
     *
     * @return string[] A sorted array of similar string
     */
    private function findAlternatives(string $name, iterable $collection) : array
    {
        $threshold = 1000.0;
        $alternatives = [];
        $collectionParts = [];
        foreach ($collection as $item) {
            $collectionParts[$item] = \explode(':', $item);
        }
        foreach (\explode(':', $name) as $i => $subname) {
            foreach ($collectionParts as $collectionName => $parts) {
                $exists = isset($alternatives[$collectionName]);
                if (!isset($parts[$i]) && $exists) {
                    $alternatives[$collectionName] += $threshold;
                    continue;
                } elseif (!isset($parts[$i])) {
                    continue;
                }
                $lev = \levenshtein($subname, $parts[$i]);
                if ($lev <= \strlen($subname) / 3 || '' !== $subname && \false !== \strpos($parts[$i], $subname)) {
                    $alternatives[$collectionName] = $exists ? $alternatives[$collectionName] + $lev : $lev;
                } elseif ($exists) {
                    $alternatives[$collectionName] += $threshold;
                }
            }
        }
        foreach ($collection as $item) {
            $lev = \levenshtein($name, $item);
            if ($lev <= \strlen($name) / 3 || \false !== \strpos($item, $name)) {
                $alternatives[$item] = isset($alternatives[$item]) ? $alternatives[$item] - $lev : $lev;
            }
        }
        $alternatives = \array_filter($alternatives, function ($lev) use($threshold) {
            return $lev < 2 * $threshold;
        });
        \ksort($alternatives, \SORT_NATURAL | \SORT_FLAG_CASE);
        return \array_keys($alternatives);
    }
    /**
     * Sets the default Command name.
     *
     * @return self
     */
    public function setDefaultCommand(string $commandName, bool $isSingleCommand = \false)
    {
        $this->defaultCommand = $commandName;
        if ($isSingleCommand) {
            // Ensure the command exist
            $this->find($commandName);
            $this->singleCommand = \true;
        }
        return $this;
    }
    /**
     * @internal
     */
    public function isSingleCommand() : bool
    {
        return $this->singleCommand;
    }
    private function splitStringByWidth(string $string, int $width) : array
    {
        // str_split is not suitable for multi-byte characters, we should use preg_split to get char array properly.
        // additionally, array_slice() is not enough as some character has doubled width.
        // we need a function to split string not by character count but by string width
        if (\false === ($encoding = \mb_detect_encoding($string, null, \true))) {
            return \str_split($string, $width);
        }
        $utf8String = \mb_convert_encoding($string, 'utf8', $encoding);
        $lines = [];
        $line = '';
        $offset = 0;
        while (\preg_match('/.{1,10000}/u', $utf8String, $m, 0, $offset)) {
            $offset += \strlen($m[0]);
            foreach (\preg_split('//u', $m[0]) as $char) {
                // test if $char could be appended to current line
                if (\mb_strwidth($line . $char, 'utf8') <= $width) {
                    $line .= $char;
                    continue;
                }
                // if not, push current line to array and make new line
                $lines[] = \str_pad($line, $width);
                $line = $char;
            }
        }
        $lines[] = \count($lines) ? \str_pad($line, $width) : $line;
        \mb_convert_variables($encoding, 'utf8', $lines);
        return $lines;
    }
    /**
     * Returns all namespaces of the command name.
     *
     * @return string[] The namespaces of the command
     */
    private function extractAllNamespaces(string $name) : array
    {
        // -1 as third argument is needed to skip the command short name when exploding
        $parts = \explode(':', $name, -1);
        $namespaces = [];
        foreach ($parts as $part) {
            if (\count($namespaces)) {
                $namespaces[] = \end($namespaces) . ':' . $part;
            } else {
                $namespaces[] = $part;
            }
        }
        return $namespaces;
    }
    private function init()
    {
        if ($this->initialized) {
            return;
        }
        $this->initialized = \true;
        foreach ($this->getDefaultCommands() as $command) {
            $this->add($command);
        }
    }
}
