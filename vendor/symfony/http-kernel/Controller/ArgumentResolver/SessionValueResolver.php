<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer2021062210\Symfony\Component\HttpKernel\Controller\ArgumentResolver;

use ConfigTransformer2021062210\Symfony\Component\HttpFoundation\Request;
use ConfigTransformer2021062210\Symfony\Component\HttpFoundation\Session\SessionInterface;
use ConfigTransformer2021062210\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use ConfigTransformer2021062210\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
/**
 * Yields the Session.
 *
 * @author Iltar van der Berg <kjarli@gmail.com>
 */
final class SessionValueResolver implements \ConfigTransformer2021062210\Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function supports(\ConfigTransformer2021062210\Symfony\Component\HttpFoundation\Request $request, \ConfigTransformer2021062210\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument) : bool
    {
        if (!$request->hasSession()) {
            return \false;
        }
        $type = $argument->getType();
        if (\ConfigTransformer2021062210\Symfony\Component\HttpFoundation\Session\SessionInterface::class !== $type && !\is_subclass_of($type, \ConfigTransformer2021062210\Symfony\Component\HttpFoundation\Session\SessionInterface::class)) {
            return \false;
        }
        return $request->getSession() instanceof $type;
    }
    /**
     * {@inheritdoc}
     */
    public function resolve(\ConfigTransformer2021062210\Symfony\Component\HttpFoundation\Request $request, \ConfigTransformer2021062210\Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata $argument) : iterable
    {
        (yield $request->getSession());
    }
}
