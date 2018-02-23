<?php

namespace uSIreF\AutoWire\Unit\Tests\Builder\Pattern\ConstructTest;

use stdClass, ArrayObject;

/**
 * This file defines class for testing construct creator.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class WithDependencies {

    /**
     * Testing construct.
     *
     * @param mixed       $required       Required value
     * @param stdClass    $withoutDefault stdClass instance
     * @param ArrayObject $withDefault    ArrayObject instance
     *
     * @return void
     */
    public function __construct($required, stdClass $withoutDefault, ArrayObject $withDefault = null) {
        return [$required, $withoutDefault, $withDefault];
    }

}