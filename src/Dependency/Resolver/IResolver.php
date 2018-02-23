<?php

namespace uSIreF\AutoWire\Dependency\Resolver;

/**
 * This file defines interface for resolver.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
interface IResolver {

    /**
     * Resolves method information for given method name.
     *
     * @param string $method Method name
     *
     * @return Definition
     */
    public function resolve(string $method): Definition;

}