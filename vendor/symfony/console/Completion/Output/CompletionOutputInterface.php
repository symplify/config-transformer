<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2022031610\Symfony\Component\Console\Completion\Output;

use ConfigTransformer2022031610\Symfony\Component\Console\Completion\CompletionSuggestions;
use ConfigTransformer2022031610\Symfony\Component\Console\Output\OutputInterface;
/**
 * Transforms the {@see CompletionSuggestions} object into output readable by the shell completion.
 *
 * @author Wouter de Jong <wouter@wouterj.nl>
 */
interface CompletionOutputInterface
{
    public function write(\ConfigTransformer2022031610\Symfony\Component\Console\Completion\CompletionSuggestions $suggestions, \ConfigTransformer2022031610\Symfony\Component\Console\Output\OutputInterface $output) : void;
}
