<?php

namespace uSIreF\AutoWire\Builder\Pattern;

use uSIreF\AutoWire\Provider;
use uSIreF\AutoWire\Builder\Exception;
use uSIreF\AutoWire\Dependency\Collector;
use uSIreF\AutoWire\Dependency\Resolver\Definition;
use ReflectionClass;

/**
 * This file defines creator class for create instance via construct method.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Construct extends APattern {

    const METHOD = '__construct';

    /**
     * Defines strict mode for matching function (if it is true then matched method must exist).
     *
     * @var boolean
     */
    protected $isStrict = false;

    /**
     * Create instance by given class name and definition of depencies via constructor method.
     *
     * @param string    $className Class name
     * @param Collector $collector Dependcies collector
     * @param Provider  $provider  Provider instance for provide dependencies
     *
     * @throws Exception
     *
     * @return object
     */
    public function create(string $className, Collector $collector, Provider $provider) {
        if (!$this->match($className)) {
            throw new Exception('Construct of class "'.$className.'" is\'t accessible.');
        }

        $definition = $collector->get($className, self::METHOD);
        $arguments  = $this->buildArguments($definition, $provider);

        $reflection = new ReflectionClass($className);
        return $reflection->newInstanceArgs($arguments);
    }

    /**
     * Returns matching definition.
     *
     * @return Definition
     */
    protected function getMatchDefinition(): Definition {
        return new Definition(self::METHOD, Definition::TYPE_PUBLIC_METHOD);
    }

}