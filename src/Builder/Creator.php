<?php

namespace uSIreF\AutoWire\Builder;

use uSIreF\AutoWire\Dependency\Collector;
use uSIreF\AutoWire\Provider;

/**
 * This file defines class for create instance.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Creator {

    /**
     * Collector instance.
     *
     * @var Collector
     */
    private $_collector;

    /**
     * Provider instance.
     *
     * @var Provider
     */
    private $_provider;

    /**
     * Finder instance.
     *
     * @var Finder
     */
    private $_finder;

    /**
     * Construct method for inject collector and provider instances.
     *
     * @param Collector $collector Collector instance
     * @param Provider  $provider  Provider instance
     * @param Finder    $finder    Finder instance (optional)
     *
     * @return void
     */
    public function __construct(Collector $collector, Provider $provider, Finder $finder = null) {
        $this->_collector = $collector;
        $this->_provider  = $provider;
        $this->_finder    = ($finder ?? new Finder());
    }

    /**
     * It returns created instance by given class name.
     *
     * @param string $className Class name
     *
     * @throws Exception
     *
     * @return object
     */
    public function create(string $className) {
        $pattern = $this->_finder->findPattern($className);

        if (!$pattern) {
            throw new Exception('Class "'.$className.'" could\'t be created.');
        }

        return $pattern->create($className, $this->_collector, $this->_provider);
    }

}