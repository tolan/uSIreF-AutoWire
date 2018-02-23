<?php

namespace uSIreF\AutoWire\Dependency;

/**
 * This file defines class for ...
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Resolver {

    /**
     * Resolves method information for given method name.
     *
     * @param string $methodOrClass Function name or classname
     * @param string $method        Method name
     *
     * @return Arguments
     *
     * @throws Exception
     */
    public function resolve(string $methodOrClass, string $method = null): Resolver\Definition {
        if (strstr($methodOrClass, '::')) {
            list($methodOrClass, $method) = explode('::', $methodOrClass, 2);
        }

        $resolver = null;
        switch (true) {
            case $methodOrClass && class_exists($methodOrClass):
                $resolver      = new Resolver\InstanceResolver($methodOrClass);
                $methodOrClass = $method;
                break;
            case function_exists($methodOrClass):
                $resolver = new Resolver\FunctionResolver();
                break;
            default:
                throw new Exception('Method "'.$method.'" can\'t be resolved.');
        }

        /* @var $resolver Resolver\IResolver */
        return $resolver->resolve($methodOrClass);
    }

}