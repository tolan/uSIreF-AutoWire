<?php

namespace uSIreF\AutoWire\Unit\Tests\Dependency\ResolverTest;

/**
 * Simple class for test with private construct method.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class SimpleTestClassPrivate {

    /**
     * Private construct method without arguments.
     *
     * @return null
     */
    private function __construct() {
        return null;
    }

}