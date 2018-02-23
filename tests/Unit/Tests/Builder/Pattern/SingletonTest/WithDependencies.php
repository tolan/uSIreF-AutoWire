<?php

namespace uSIreF\AutoWire\Unit\Tests\Builder\Pattern\SingletonTest;

use stdClass, ArrayObject;

/**
 * This file defines class for testing singleton creator.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class WithDependencies {

    /**
     * Testing singleton.
     *
     * @param mixed       $required       Required value
     * @param stdClass    $withoutDefault stdClass instance
     * @param ArrayObject $withDefault    ArrayObject instance
     *
     * @return void
     */
    public static function getInstance($required, stdClass $withoutDefault, ArrayObject $withDefault = null) {
        return new self([$required, $withoutDefault, $withDefault]);
    }

}