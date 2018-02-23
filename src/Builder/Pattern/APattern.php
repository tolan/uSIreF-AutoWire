<?php

namespace uSIreF\AutoWire\Builder\Pattern;

use uSIreF\AutoWire\Provider;
use uSIreF\AutoWire\Dependency\Helper\MethodType;
use uSIreF\AutoWire\Dependency\Resolver\{Definition, Parameter};
use uSIreF\AutoWire\Builder\Exception;

use ReflectionClass, ReflectionMethod;

/**
 * This file defines abstract class for create instance.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
abstract class APattern implements IPattern {

    /**
     * Defines strict mode for matching function (if it is true then matched method must exist).
     *
     * @var boolean
     */
    protected $isStrict = true;

    /**
     * Gets matching definition.
     *
     * @return Definition
     */
    abstract protected function getMatchDefinition(): Definition;

    /**
     * It returns that the class can be created by pattern.
     *
     * @param string $className Class name
     *
     * @return bool
     */
    public function match(string $className): bool {
        $match     = $this->getMatchDefinition();
        $reflClass = new ReflectionClass($className);
        $result    = !$this->isStrict;

        foreach ($reflClass->getMethods() as $method) { /* @var $method ReflectionMethod */
            if ($match->getName() === $method->getName()) {
                $result = $match->getType() === MethodType::resolve($method);
                break;
            }
        }

        return $result;
    }

    /**
     * It builds arguments for create method by given definitions.
     *
     * @param Definition $definition Method definition
     * @param Provider   $provider   Provider instance for resolve dependencies
     *
     * @return array
     *
     * @throws Exception
     */
    protected function buildArguments(Definition $definition, Provider $provider): array {
        $arguments = [];
        foreach ($definition->getParameters() as $parameter) { /* @var $parameter Parameter */
            if (!$parameter->isClass && !$provider->has($parameter->name)) {
                if ($parameter->optional) {
                    continue;
                }

                throw new Exception('Parameter "'.$parameter->name.' can\'t be resolved.');
            }

            $value = Helper\Parameter::getValue($provider, $parameter);
            Helper\Parameter::validate($parameter, $value);
            $arguments[$parameter->name] = $value;
        }

        return $arguments;
    }

}