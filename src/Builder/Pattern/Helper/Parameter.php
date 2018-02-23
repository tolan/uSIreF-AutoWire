<?php

namespace uSIreF\AutoWire\Builder\Pattern\Helper;

use uSIreF\AutoWire\Provider;
use uSIreF\AutoWire\Dependency\Resolver;
use uSIreF\AutoWire\Builder\Exception;

/**
 * This file defines class for help with parameters.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Parameter {

    /**
     * Returns value by given parameter.
     *
     * @param Provider           $provider  Provider instance
     * @param Resolver\Parameter $parameter Parameter instance
     *
     * @return mixed
     */
    public static function getValue(Provider $provider, Resolver\Parameter $parameter) {
        $provideName = ($provider->has($parameter->name)) ? $parameter->name : $parameter->type;
        $toProvide   = (!$parameter->optional || $provider->has($provideName)) && ($parameter->isClass || !$parameter->default);
        $value       = ($toProvide) ? $provider->get($provideName) : $parameter->default;

        return $value;
    }

    /**
     * It validates that the value is valid to parameter definition.
     *
     * @param Resolver\Parameter $parameter Parameter instance
     * @param mixed              $value     Value to validatoin
     *
     * @throws Exception
     *
     * @return void
     */
    public static function validate(Resolver\Parameter $parameter, $value) {
        $parameterType = $parameter->type;
        $valueType     = gettype($value);

        $result = false;
        switch (true) {
            case $parameterType === null:
            case $parameterType === $valueType:
            case $parameterType === 'bool' && $valueType === 'boolean':
            case $parameterType === 'int' && $valueType === 'integer':
            case $valueType === 'NULL' && $parameter->optional:
            case $valueType === 'object' && $parameter->isClass:
                $result = true;
                break;
        }

        if (!$result) {
            throw new Exception('Wrong argument type "'.$valueType.'" of parameter "'.$parameter->name.'" ('.$parameter->type.').');
        }
    }

}