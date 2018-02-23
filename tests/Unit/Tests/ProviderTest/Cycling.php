<?php

namespace uSIreF\AutoWire\Unit\Tests\ProviderTest;

/**
 * This file defines testing class for ProviderTest.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class Cycling {

    /**
     * Testing construct method.
     *
     * @param Cyclling $cyc Dependency
     *
     * @return void
     */
    public function __construct(Cycling $cyc) {
        return [$cyc];
    }

}