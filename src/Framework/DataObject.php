<?php

declare(strict_types=1);

namespace Framework;

/**
 * Class DataObject
 */
class DataObject implements \ArrayAccess, \JsonSerializable
{
    /** @var array $_data */
    protected $_data = array();

    public function __construct(array $array)
    {
        $this->_data = $array;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->_data);
    }

    public function offsetGet($offset)
    {
        return $this->_data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->_data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->_data[$offset]);
    }

    public function addData(array $array)
    {
        foreach ($array as $key => $value) {
            $this->setData($key, $value);
        }
        return $this;
    }

    public function setData($key, $value = null)
    {
        if ($key = (array) $key) {
            $this->_data = $key;
        } else {
            $this->_data[$key] = $value;
        }
        return $this;
    }

    public function getData($key = '')
    {
        if ($key == '') {
            return $this->_data;
        }
        return $this->_data[$key] ?? null;
    }

    public function jsonSerialize()
    {
        return $this->_data;
    }
}