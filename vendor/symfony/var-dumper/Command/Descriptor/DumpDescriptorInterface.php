<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202108042\Symfony\Component\VarDumper\Command\Descriptor;

use ConfigTransformer202108042\Symfony\Component\Console\Output\OutputInterface;
use ConfigTransformer202108042\Symfony\Component\VarDumper\Cloner\Data;
/**
 * @author Maxime Steinhausser <maxime.steinhausser@gmail.com>
 */
interface DumpDescriptorInterface
{
    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param \Symfony\Component\VarDumper\Cloner\Data $data
     * @param mixed[] $context
     * @param int $clientId
     */
    public function describe($output, $data, $context, $clientId) : void;
}
