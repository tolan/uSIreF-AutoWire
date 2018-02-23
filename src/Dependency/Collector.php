<?php

namespace uSIreF\AutoWire\Dependency;

use uSIreF\AutoWire\Dependency\Resolver\Definition;

/**
 * This file defines class for collect method arguments.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Collector {

    /**
     * Resolver instance.
     *
     * @var Resolver
     */
    private $_resolver;

    /**
     * Collected arguments.
     *
     * @var [Arguments]
     */
    private $_collected = [];

    /**
     * Construct method for set Resolver.
     *
     * @param Resolver $resolver Resolver instance
     */
    public function __construct(Resolver $resolver) {
        $this->_resolver = $resolver;
    }

    /**
     * Gets informations about given function of method class.
     *
     * @param string $methodOrClass Function name or classname
     * @param string $method        Method name
     *
     * @return Arguments
     */
    public function get(string $methodOrClass, string $method = null): Definition {
        if (!array_key_exists($methodOrClass.'::'.$method, $this->_collected)) {
            $this->_collected[$methodOrClass.'::'.$method] = $this->_resolver->resolve($methodOrClass, $method);
        }

        return $this->_collected[$methodOrClass.'::'.$method];
    }

}