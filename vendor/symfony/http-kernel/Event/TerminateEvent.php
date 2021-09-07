<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202109079\Symfony\Component\HttpKernel\Event;

use ConfigTransformer202109079\Symfony\Component\HttpFoundation\Request;
use ConfigTransformer202109079\Symfony\Component\HttpFoundation\Response;
use ConfigTransformer202109079\Symfony\Component\HttpKernel\HttpKernelInterface;
/**
 * Allows to execute logic after a response was sent.
 *
 * Since it's only triggered on main requests, the `getRequestType()` method
 * will always return the value of `HttpKernelInterface::MAIN_REQUEST`.
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
final class TerminateEvent extends \ConfigTransformer202109079\Symfony\Component\HttpKernel\Event\KernelEvent
{
    private $response;
    public function __construct(\ConfigTransformer202109079\Symfony\Component\HttpKernel\HttpKernelInterface $kernel, \ConfigTransformer202109079\Symfony\Component\HttpFoundation\Request $request, \ConfigTransformer202109079\Symfony\Component\HttpFoundation\Response $response)
    {
        parent::__construct($kernel, $request, \ConfigTransformer202109079\Symfony\Component\HttpKernel\HttpKernelInterface::MAIN_REQUEST);
        $this->response = $response;
    }
    public function getResponse() : \ConfigTransformer202109079\Symfony\Component\HttpFoundation\Response
    {
        return $this->response;
    }
}
