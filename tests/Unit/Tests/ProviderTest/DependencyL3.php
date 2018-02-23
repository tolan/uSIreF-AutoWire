<?php

namespace uSIreF\AutoWire\Unit\Tests\ProviderTest;

/**
 * This file defines testing class for ProviderTest.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class DependencyL3 {

    /**
     * Testing construct method.
     *
     * @param DependencyL1 $dep  Dependency
     * @param DependencyL2 $dep2 Dependency
     *
     * @return void
     */
    public function __construct(DependencyL1 $dep, DependencyL2 $dep2) {
        return [$dep, $dep2];
    }

}