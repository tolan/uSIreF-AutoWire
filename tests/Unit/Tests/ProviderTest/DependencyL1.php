<?php

namespace uSIreF\AutoWire\Unit\Tests\ProviderTest;

use stdClass;

/**
 * This file defines testing class for ProviderTest.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class DependencyL1 {

    /**
     * Testing construct method.
     *
     * @param stdClass $std Dependency
     *
     * @return void
     */
    public function __construct(stdClass $std) {
        return [$std];
    }

}