<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2022041410\Symfony\Component\Console\Tester\Constraint;

use ConfigTransformer2022041410\PHPUnit\Framework\Constraint\Constraint;
use ConfigTransformer2022041410\Symfony\Component\Console\Command\Command;
final class CommandIsSuccessful extends \ConfigTransformer2022041410\PHPUnit\Framework\Constraint\Constraint
{
    /**
     * {@inheritdoc}
     */
    public function toString() : string
    {
        return 'is successful';
    }
    /**
     * {@inheritdoc}
     */
    protected function matches($other) : bool
    {
        return \ConfigTransformer2022041410\Symfony\Component\Console\Command\Command::SUCCESS === $other;
    }
    /**
     * {@inheritdoc}
     */
    protected function failureDescription($other) : string
    {
        return 'the command ' . $this->toString();
    }
    /**
     * {@inheritdoc}
     */
    protected function additionalFailureDescription($other) : string
    {
        $mapping = [\ConfigTransformer2022041410\Symfony\Component\Console\Command\Command::FAILURE => 'Command failed.', \ConfigTransformer2022041410\Symfony\Component\Console\Command\Command::INVALID => 'Command was invalid.'];
        return $mapping[$other] ?? \sprintf('Command returned exit status %d.', $other);
    }
}
