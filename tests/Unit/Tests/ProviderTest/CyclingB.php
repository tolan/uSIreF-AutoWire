<?php

namespace uSIreF\AutoWire\Unit\Tests\ProviderTest;

/**
 * This file defines testing class for ProviderTest.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class CyclingB {

    /**
     * Testing construct method.
     *
     * @param CyclingA $cyc Dependency
     *
     * @return void
     */
    public function __construct(CyclingA $cyc) {
        return [$cyc];
    }

}