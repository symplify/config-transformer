<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2021081110\Symfony\Component\HttpFoundation\File;

/**
 * A PHP stream of unknown size.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class Stream extends \ConfigTransformer2021081110\Symfony\Component\HttpFoundation\File\File
{
    /**
     * {@inheritdoc}
     *
     * @return int|false
     */
    public function getSize()
    {
        return \false;
    }
}
