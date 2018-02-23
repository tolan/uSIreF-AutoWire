<?php

namespace uSIreF\AutoWire;

/**
 * This file defines class for prevent cycling dependencies.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class CycleHelper {

    /**
     * Set of active classes.
     *
     * @var array
     */
    private $_active = [];

    /**
     * It starts and checks cycling prevention for class.
     *
     * @param string $className Class name
     *
     * @return CycleHelper
     *
     * @throws Exception
     */
    public function start(string $className): CycleHelper {
        if (array_key_exists($className, $this->_active)) {
            throw new Exception('Class "'.$className.'" has cycling dependencies: ['.join(', ', array_keys($this->_active)).']!');
        }

        $this->_active[$className] = true;

        return $this;
    }

    /**
     * It ends cycling prevention for class.
     *
     * @param string $className Class name
     *
     * @return CycleHelper
     *
     * @throws Exception
     */
    public function commit(string $className): CycleHelper {
        if (!array_key_exists($className, $this->_active)) {
            throw new Exception('Something is wrong in cycling with class "'.$className.'".');
        }

        unset($this->_active[$className]);

        return $this;
    }

}