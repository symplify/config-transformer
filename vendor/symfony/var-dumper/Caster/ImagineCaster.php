<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202108231\Symfony\Component\VarDumper\Caster;

use ConfigTransformer202108231\Imagine\Image\ImageInterface;
use ConfigTransformer202108231\Symfony\Component\VarDumper\Cloner\Stub;
/**
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
final class ImagineCaster
{
    public static function castImage(\ConfigTransformer202108231\Imagine\Image\ImageInterface $c, array $a, \ConfigTransformer202108231\Symfony\Component\VarDumper\Cloner\Stub $stub, bool $isNested) : array
    {
        $imgData = $c->get('png');
        if (\strlen($imgData) > 1 * 1000 * 1000) {
            $a += [\ConfigTransformer202108231\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL . 'image' => new \ConfigTransformer202108231\Symfony\Component\VarDumper\Caster\ConstStub($c->getSize())];
        } else {
            $a += [\ConfigTransformer202108231\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL . 'image' => new \ConfigTransformer202108231\Symfony\Component\VarDumper\Caster\ImgStub($imgData, 'image/png', $c->getSize())];
        }
        return $a;
    }
}
