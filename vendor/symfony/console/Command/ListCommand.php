<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202112309\Symfony\Component\Console\Command;

use ConfigTransformer202112309\Symfony\Component\Console\Completion\CompletionInput;
use ConfigTransformer202112309\Symfony\Component\Console\Completion\CompletionSuggestions;
use ConfigTransformer202112309\Symfony\Component\Console\Descriptor\ApplicationDescription;
use ConfigTransformer202112309\Symfony\Component\Console\Helper\DescriptorHelper;
use ConfigTransformer202112309\Symfony\Component\Console\Input\InputArgument;
use ConfigTransformer202112309\Symfony\Component\Console\Input\InputInterface;
use ConfigTransformer202112309\Symfony\Component\Console\Input\InputOption;
use ConfigTransformer202112309\Symfony\Component\Console\Output\OutputInterface;
/**
 * ListCommand displays the list of all available commands for the application.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ListCommand extends \ConfigTransformer202112309\Symfony\Component\Console\Command\Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('list')->setDefinition([new \ConfigTransformer202112309\Symfony\Component\Console\Input\InputArgument('namespace', \ConfigTransformer202112309\Symfony\Component\Console\Input\InputArgument::OPTIONAL, 'The namespace name'), new \ConfigTransformer202112309\Symfony\Component\Console\Input\InputOption('raw', null, \ConfigTransformer202112309\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'To output raw command list'), new \ConfigTransformer202112309\Symfony\Component\Console\Input\InputOption('format', null, \ConfigTransformer202112309\Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED, 'The output format (txt, xml, json, or md)', 'txt'), new \ConfigTransformer202112309\Symfony\Component\Console\Input\InputOption('short', null, \ConfigTransformer202112309\Symfony\Component\Console\Input\InputOption::VALUE_NONE, 'To skip describing commands\' arguments')])->setDescription('List commands')->setHelp(<<<'EOF'
The <info>%command.name%</info> command lists all commands:

  <info>%command.full_name%</info>

You can also display the commands for a specific namespace:

  <info>%command.full_name% test</info>

You can also output the information in other formats by using the <comment>--format</comment> option:

  <info>%command.full_name% --format=xml</info>

It's also possible to get raw list of commands (useful for embedding command runner):

  <info>%command.full_name% --raw</info>
EOF
);
    }
    /**
     * {@inheritdoc}
     */
    protected function execute(\ConfigTransformer202112309\Symfony\Component\Console\Input\InputInterface $input, \ConfigTransformer202112309\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $helper = new \ConfigTransformer202112309\Symfony\Component\Console\Helper\DescriptorHelper();
        $helper->describe($output, $this->getApplication(), ['format' => $input->getOption('format'), 'raw_text' => $input->getOption('raw'), 'namespace' => $input->getArgument('namespace'), 'short' => $input->getOption('short')]);
        return 0;
    }
    public function complete(\ConfigTransformer202112309\Symfony\Component\Console\Completion\CompletionInput $input, \ConfigTransformer202112309\Symfony\Component\Console\Completion\CompletionSuggestions $suggestions) : void
    {
        if ($input->mustSuggestArgumentValuesFor('namespace')) {
            $descriptor = new \ConfigTransformer202112309\Symfony\Component\Console\Descriptor\ApplicationDescription($this->getApplication());
            $suggestions->suggestValues(\array_keys($descriptor->getNamespaces()));
            return;
        }
        if ($input->mustSuggestOptionValuesFor('format')) {
            $helper = new \ConfigTransformer202112309\Symfony\Component\Console\Helper\DescriptorHelper();
            $suggestions->suggestValues($helper->getFormats());
        }
    }
}
