<?php

namespace uSIreF\AutoWire\Builder\Pattern;

use uSIreF\AutoWire\Provider;
use uSIreF\AutoWire\Builder\Exception;
use uSIreF\AutoWire\Dependency\Collector;
use uSIreF\AutoWire\Dependency\Resolver\{Definition, Parameter};

use ReflectionMethod;

/**
 * This file defines creator class for create instance via getInstance static method.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Singleton extends APattern {

    const METHOD = 'getInstance';

    /**
     * Create instance by given class name and definition of depencies via getInstance static method.
     *
     * @param string    $className Class name
     * @param Collector $collector Dependencies collector
     * @param Provider  $provider  Provider instance for provide dependencies
     *
     * @throws Exception
     *
     * @return object
     */
    public function create(string $className, Collector $collector, Provider $provider) {
        if (!$this->match($className)) {
            throw new Exception('Singleton method "'.self::METHOD.'" of class "'.$className.'" is\'t accessible.');
        }

        $definition = $collector->get($className, self::METHOD);
        $arguments  = $this->buildArguments($definition, $provider);
        return forward_static_call_array([$className, $definition->getName()], $arguments);
    }

    /**
     * Returns matching definition.
     *
     * @return Definition
     */
    protected function getMatchDefinition(): Definition {
        return new Definition(self::METHOD, Definition::TYPE_STATIC_PUBLIC_METHOD);
    }

}