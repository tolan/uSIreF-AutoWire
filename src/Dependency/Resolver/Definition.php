<?php

namespace uSIreF\AutoWire\Dependency\Resolver;

use uSIreF\AutoWire\Dependency\Exception;

/**
 * This file defines class for collect informations about method.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Definition {

    const TYPE_FUNCTION                = 'function';
    const TYPE_PUBLIC_METHOD           = 'public';
    const TYPE_PROTECTED_METHOD        = 'protected';
    const TYPE_PRIVATE_METHOD          = 'private';
    const TYPE_STATIC_PUBLIC_METHOD    = 'static-public';
    const TYPE_STATIC_PROTECTED_METHOD = 'static-protected';
    const TYPE_STATIC_PRIVATE_METHOD   = 'static-private';

    /**
     * Set of available arguments type
     *
     * @var array
     */
    private static $_availableTypes = [
        self::TYPE_FUNCTION,
        self::TYPE_PUBLIC_METHOD,
        self::TYPE_PROTECTED_METHOD,
        self::TYPE_PRIVATE_METHOD,
        self::TYPE_STATIC_PUBLIC_METHOD,
        self::TYPE_STATIC_PROTECTED_METHOD,
        self::TYPE_STATIC_PRIVATE_METHOD,
    ];

    /**
     * Name of function.
     *
     * @var string
     */
    private $_name;

    /**
     * Method type.
     *
     * @var string
     */
    private $_type;

    /**
     * Set of assigned parameters.
     *
     * @var array
     */
    private $_parameters = [];

    /**
     * Construct method for set type of method.
     *
     * @param string $name Function name
     * @param string $type Type of method (one of constant TYPE_*)
     *
     * @throws Exception
     */
    public function __construct(string $name, string $type) {
        if (!in_array($type, self::$_availableTypes)) {
            throw new Exception('Type "'.$type.'" is not supported.');
        }

        $this->_name = $name;
        $this->_type = $type;
    }

    /**
     * Returns name of function.
     *
     * @return string
     */
    public function getName(): string {
        return $this->_name;
    }

    /**
     * Returns type of method (one of constant TYPE_*).
     *
     * @return string
     */
    public function getType(): string {
        return $this->_type;
    }

    /**
     * Adds parameter.
     *
     * @param Parameter $parameter Param instance
     *
     * @return Definition
     */
    public function add(Parameter $parameter): Definition {
        $this->_parameters[] = $parameter;

        return $this;
    }

    /**
     * Returns all specified parameters.
     *
     * @return [Parameter]
     */
    public function getParameters(): array {
        return $this->_parameters;
    }

}