<?php

namespace uSIreF\AutoWire\Dependency\Resolver;

use uSIreF\AutoWire\Dependency\Exception;
use uSIreF\AutoWire\Dependency\Helper\MethodType;

use ReflectionClass;
use ReflectionMethod;

/**
 * This file defines class for ...
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class InstanceResolver implements IResolver {

    /**
     * Class name.
     *
     * @var string
     */
    private $_className;

    const DEFAULT_METHOD = '__construct';

    /**
     * Construct method for set class name.
     *
     * @param string $className Class name
     *
     * @throws Exception
     */
    public function __construct(string $className) {
        if (!class_exists($className)) {
            throw new Exception('Class with class name "'.$className.'" does\'t exist.');
        }

        $this->_className = $className;
    }

    /**
     * Resolves arguments information for given method.
     *
     * @param string $methodName Name of method
     *
     * @return Definition
     *
     * @throws Exception
     */
    public function resolve(string $methodName = null): Definition {
        $methodName = ($methodName ?? self::DEFAULT_METHOD);
        $reflClass  = new ReflectionClass($this->_className);
        $methods    = $reflClass->getMethods();

        $targetMethod = null;
        foreach ($methods as $method) { /* @var $method ReflectionMethod */
            if ($method->getName() === $methodName) {
                $targetMethod = $method; /* @var $targetMethod ReflectionMethod */
                break;
            }
        }

        switch (true) {
            case $targetMethod:
                $method     = new Definition($methodName, MethodType::resolve($targetMethod));
                $parameters = $targetMethod->getParameters();
                foreach ($parameters as $parameter) {
                    $method->add(new Parameter($parameter));
                }
                break;
            case !$targetMethod && $methodName === self::DEFAULT_METHOD:
                $method = new Definition($methodName, Definition::TYPE_PUBLIC_METHOD);
                break;
            default:
                throw new Exception('Method "'.$method.'" is not defined in class "'.$this->_className.'".');
        }

        return $method;
    }

}