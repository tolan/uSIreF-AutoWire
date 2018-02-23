<?php

namespace uSIreF\AutoWire\Dependency\Resolver;

use uSIreF\AutoWire\Dependency\Exception;
use ReflectionFunction;

/**
 * This file defines class for ...
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class FunctionResolver implements IResolver {

    /**
     * Resolves arguments information for given function.
     *
     * @param string $functionName Function name
     *
     * @throws Exception
     *
     * @return Definition
     */
    public function resolve(string $functionName): Definition {
        if (!function_exists($functionName)) {
            throw new Exception('Function "'.$functionName.'" does\'t exist.');
        }

        $reflection = new ReflectionFunction($functionName);
        $parameters = $reflection->getParameters();

        $result = new Definition($functionName, Definition::TYPE_FUNCTION);
        foreach ($parameters as $parameter) {
            $result->add(new Parameter($parameter));
        }

        return $result;
    }

}