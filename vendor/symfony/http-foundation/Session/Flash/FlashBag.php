<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ConfigTransformer202107121\Symfony\Component\HttpFoundation\Session\Flash;

/**
 * FlashBag flash message container.
 *
 * @author Drak <drak@zikula.org>
 */
class FlashBag implements \ConfigTransformer202107121\Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface
{
    private $name = 'flashes';
    private $flashes = [];
    private $storageKey;
    /**
     * @param string $storageKey The key used to store flashes in the session
     */
    public function __construct(string $storageKey = '_symfony_flashes')
    {
        $this->storageKey = $storageKey;
    }
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $flashes
     */
    public function initialize(&$flashes)
    {
        $this->flashes =& $flashes;
    }
    /**
     * {@inheritdoc}
     * @param string $type
     */
    public function add($type, $message)
    {
        $this->flashes[$type][] = $message;
    }
    /**
     * {@inheritdoc}
     * @param string $type
     * @param mixed[] $default
     */
    public function peek($type, $default = [])
    {
        return $this->has($type) ? $this->flashes[$type] : $default;
    }
    /**
     * {@inheritdoc}
     */
    public function peekAll()
    {
        return $this->flashes;
    }
    /**
     * {@inheritdoc}
     * @param string $type
     * @param mixed[] $default
     */
    public function get($type, $default = [])
    {
        if (!$this->has($type)) {
            return $default;
        }
        $return = $this->flashes[$type];
        unset($this->flashes[$type]);
        return $return;
    }
    /**
     * {@inheritdoc}
     */
    public function all()
    {
        $return = $this->peekAll();
        $this->flashes = [];
        return $return;
    }
    /**
     * {@inheritdoc}
     * @param string $type
     */
    public function set($type, $messages)
    {
        $this->flashes[$type] = (array) $messages;
    }
    /**
     * {@inheritdoc}
     * @param mixed[] $messages
     */
    public function setAll($messages)
    {
        $this->flashes = $messages;
    }
    /**
     * {@inheritdoc}
     * @param string $type
     */
    public function has($type)
    {
        return \array_key_exists($type, $this->flashes) && $this->flashes[$type];
    }
    /**
     * {@inheritdoc}
     */
    public function keys()
    {
        return \array_keys($this->flashes);
    }
    /**
     * {@inheritdoc}
     */
    public function getStorageKey()
    {
        return $this->storageKey;
    }
    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        return $this->all();
    }
}
