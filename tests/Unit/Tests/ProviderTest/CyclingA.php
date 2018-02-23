<?php

namespace uSIreF\AutoWire\Unit\Tests\ProviderTest;

/**
 * This file defines testing class for ProviderTest.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class CyclingA {

    /**
     * Testing construct method.
     *
     * @param CyclingB $cyc Dependency
     *
     * @return void
     */
    public function __construct(CyclingB $cyc) {
        return [$cyc];
    }

}