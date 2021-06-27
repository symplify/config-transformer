<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202106279\Symfony\Component\HttpKernel\DataCollector;

use ConfigTransformer202106279\Symfony\Component\HttpFoundation\Request;
use ConfigTransformer202106279\Symfony\Component\HttpFoundation\Response;
/**
 * AjaxDataCollector.
 *
 * @author Bart van den Burg <bart@burgov.nl>
 *
 * @final
 */
class AjaxDataCollector extends \ConfigTransformer202106279\Symfony\Component\HttpKernel\DataCollector\DataCollector
{
    public function collect(\ConfigTransformer202106279\Symfony\Component\HttpFoundation\Request $request, \ConfigTransformer202106279\Symfony\Component\HttpFoundation\Response $response, \Throwable $exception = null)
    {
        // all collecting is done client side
    }
    public function reset()
    {
        // all collecting is done client side
    }
    public function getName()
    {
        return 'ajax';
    }
}
