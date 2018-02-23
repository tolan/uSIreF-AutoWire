<?php

namespace uSIreF\AutoWire\Builder\Pattern;

use uSIreF\AutoWire\Provider;
use uSIreF\AutoWire\Dependency\Collector;

/**
 * This file defines interace for Pattern.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
interface IPattern {

    /**
     * Create instance by given class name and definition of depencies.
     *
     * @param string    $className Class name
     * @param Collector $collector Dependencies collector
     * @param Provider  $provider  Provider instance for provide dependencies
     *
     * @return object
     */
    public function create(string $className, Collector $collector, Provider $provider);

}