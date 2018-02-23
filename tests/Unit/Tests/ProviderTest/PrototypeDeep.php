<?php

namespace uSIreF\AutoWire\Unit\Tests\ProviderTest;

/**
 * This file defines class for ProviderTest.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class PrototypeDeep {

    /**
     * DependencyL1 instance.
     *
     * @var DependencyL1
     */
    public $dep;

    /**
     * Construct method.
     *
     * @param DependencyL1 $dep Dependency
     */
    public function __construct(DependencyL1 $dep) {
        $this->dep = $dep;
    }

}