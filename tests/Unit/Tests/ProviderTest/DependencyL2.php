<?php

namespace uSIreF\AutoWire\Unit\Tests\ProviderTest;

/**
 * This file defines testing class for ProviderTest.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class DependencyL2 {

    /**
     * Testing construct method.
     *
     * @param DependencyL1 $dep Dependency
     *
     * @return void
     */
    public function __construct(DependencyL1 $dep) {
        return [$dep];
    }

}