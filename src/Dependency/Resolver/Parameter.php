<?php

namespace uSIreF\AutoWire\Dependency\Resolver;

use ReflectionParameter;

/**
 * This file defines class for Resolve parameter.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Parameter {

    /**
     * Parameter name.
     *
     * @var string
     */
    public $name;

    /**
     * Parameter position.
     *
     * @var integer
     */
    public $position;

    /**
     * Parameter internal type.
     *
     * @var string
     */
    public $type;

    /**
     * Parameter optional flag.
     *
     * @var boolean
     */
    public $optional;

    /**
     * Parameter default value.
     *
     * @var string
     */
    public $default;

    /**
     * Paramater that is class.
     *
     * @var boolean
     */
    public $isClass;

    /**
     * Loads basic information of parameter.
     *
     * @param ReflectionParameter $parameter ReflectionParameter instance
     *
     * @return void
     */
    public function __construct(ReflectionParameter $parameter) {
        $this->name     = $parameter->getName();
        $this->position = $parameter->getPosition();
        $this->type     = $parameter->getType() ? (string)$parameter->getType() : null;
        $this->optional = $parameter->isOptional();
        $this->default  = $parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null;
        $this->isClass  = (boolean)$parameter->getClass();
    }

}