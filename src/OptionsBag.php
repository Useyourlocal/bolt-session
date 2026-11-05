<?php

namespace Bolt\Session;

use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * This is a Bag. It does things.
 *
 * @author Carson Full <carsonfull@gmail.com>
 */
class OptionsBag extends ParameterBag implements \ArrayAccess
{
    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }
}
