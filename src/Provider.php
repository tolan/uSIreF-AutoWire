<?php

namespace uSIreF\AutoWire;

use uSIreF\AutoWire\Builder\Creator;
use uSIreF\AutoWire\Dependency\{Collector, Resolver};

/**
 * This file defines class for providing value (include all dependencies) and collect them into one place.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Provider {

    /**
     * Container instance.
     *
     * @var Container
     */
    private $_container;

    /**
     * CycleHelper instance.
     *
     * @var CycleHelper
     */
    private $_cycleHelper;

    /**
     * Collector instance.
     *
     * @var Collector
     */
    private $_collector;

    /**
     * Builder creator instance.
     *
     * @var Creator
     */
    private $_creator;

    /**
     * Construct method which initialize instance.
     *
     * @param Container   $container Container instance (optional)
     * @param CycleHelper $helper    CycleHelper instance (optional)
     * @param Collector   $collector Collector instance (optional)
     * @param Creator     $creator   Creator instance (optional)
     *
     * @return void
     */
    public function __construct(Container $container = null, CycleHelper $helper = null, Collector $collector = null, Creator $creator = null) {
        $this->_container   = ($container ?? new Container());
        $this->_cycleHelper = ($helper ?? new CycleHelper());
        $this->_collector   = ($collector ?? new Collector(new Resolver()));
        $this->_creator     = ($creator ?? new Creator($this->_collector, $this));

        $this->set($this);
    }

    /**
     * Gets value from stack. It find value by name and then by classname.
     * If value is not in stack then it create value/instance with dependencies and save it to stack (lazy load principle).
     *
     * @param string $name Name of value
     *
     * @return object
     */
    public function get(string $name) {
        $instance = null;
        if ($this->_container->has($name)) {
            $instance = $this->_container->get($name);
        } else {
            $this->_cycleHelper->start($name);
            $instance = $this->_creator->create($name);
            $this->_cycleHelper->commit($name);
            $this->_container->set($instance, $name);
        }

        return $instance;
    }

    /**
     * Returns that the value with name is set.
     *
     * @param string $name Name of value
     *
     * @return boolean
     */
    public function has(string $name): bool {
        return $this->_container->has($name);
    }

    /**
     * Sets value into stack by name.
     *
     * @param mixed  $value Value
     * @param string $name  Name of value (optional)
     *
     * @return Provider
     */
    public function set($value, string $name = null): Provider {
        $this->_container->set($value, $name);

        return $this;
    }

    /**
     * Unsets value from stack.
     *
     * @param string $name Name of value
     *
     * @return Provider
     */
    public function reset(string $name = null): Provider {
        $this->_container->reset($name);

        return $this;
    }

    /**
     * Return new instance.
     *
     * @param string  $name Name of value
     * @param boolean $deep Flag for create new dependencies
     *
     * @return object
     */
    public function prototype(string $name, bool $deep = false) {
        $prototype = null;
        if ($deep === false) {
            $prototype = $this->_creator->create($name);
        } else {
            $backup           = $this->_container;
            $this->_container = clone $this->_container;

            $this->_container->reset();

            $prototype        = $this->get($name);
            $this->_container = $backup;
        }

        return $prototype;
    }

}