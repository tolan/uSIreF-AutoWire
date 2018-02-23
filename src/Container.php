<?php

namespace uSIreF\AutoWire;

/**
 * This file defines class for collecting values.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Container {

    /**
     * Storage for values.
     *
     * @var array
     */
    private $_values = [];

    /**
     * Gets value from stack. It finds value by name and then by classname.
     *
     * @param string $name Name of value
     *
     * @return object|name
     */
    public function get(string $name) {
        $value = null;
        $key   = $this->_findKey($name);
        if ($key !== null) {
            $value = $this->_values[$key]['value'];
        }

        return $value;
    }

    /**
     * Returns that the value with name is set.
     *
     * @param string $name Name of value
     *
     * @return boolean
     */
    public function has(string $name): bool {
        return $this->_findKey($name) !== null;
    }

    /**
     * Sets value into stack by name.
     *
     * @param mixed  $value Value
     * @param string $name  Name of value (optional)
     *
     * @return Container
     *
     * @throws Exception
     */
    public function set($value, string $name = null): Container {
        if ($name === null) {
            if (!is_object($value)) {
                throw new Exception('Non-object value must have defined name.');
            } else {
                $name = get_class($value);
            }
        }

        $this->reset($name);

        $this->_values[] = [
            'name'      => $this->_getName($name),
            'classname' => is_object($value) ? $this->_getName(get_class($value)) : null,
            'value'     => $value
        ];

        return $this;
    }

    /**
     * Unsets value from stack.
     *
     * @param string $name Name of value
     *
     * @return Container
     */
    public function reset(string $name = null): Container {
        if ($name === null) {
            $this->_values = [];
        } else {
            $key = $this->_findKey($name);
            if ($key !== null) {
                unset($this->_values[$key]);
            }
        }

        return $this;
    }

    /**
     * Returns short name.
     *
     * @param string $name Name of value
     *
     * @return string
     */
    private function _getName(string $name): string {
        return ltrim($name, '\\');
    }

    /**
     * Finds key in values by given name.
     *
     * @param string $name Name of value
     *
     * @return int|null
     */
    private function _findKey(string $name) {
        $shortName = $this->_getName($name);
        $result    = null;
        foreach ($this->_values as $key => $value) {
            if (in_array($shortName, [$value['name'], $value['classname']])) {
                $result = $key;
                break;
            }
        }

        return $result;
    }

}