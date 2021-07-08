<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202107081\Symfony\Component\HttpFoundation\Session\Storage;

use ConfigTransformer202107081\Symfony\Component\HttpFoundation\Request;
// Help opcache.preload discover always-needed symbols
\class_exists(\ConfigTransformer202107081\Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage::class);
/**
 * @author Jérémy Derussé <jeremy@derusse.com>
 */
class MockFileSessionStorageFactory implements \ConfigTransformer202107081\Symfony\Component\HttpFoundation\Session\Storage\SessionStorageFactoryInterface
{
    private $savePath;
    private $name;
    private $metaBag;
    /**
     * @see MockFileSessionStorage constructor.
     */
    public function __construct(string $savePath = null, string $name = 'MOCKSESSID', \ConfigTransformer202107081\Symfony\Component\HttpFoundation\Session\Storage\MetadataBag $metaBag = null)
    {
        $this->savePath = $savePath;
        $this->name = $name;
        $this->metaBag = $metaBag;
    }
    public function createStorage(?\ConfigTransformer202107081\Symfony\Component\HttpFoundation\Request $request) : \ConfigTransformer202107081\Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface
    {
        return new \ConfigTransformer202107081\Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage($this->savePath, $this->name, $this->metaBag);
    }
}
