<?php

namespace uSIreF\AutoWire\Unit\Tests\Builder\Pattern\SingletonTest;

/**
 * This file defines class for testing singleton creator.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class SimpleClass {

    /**
     * Testing singleton.
     *
     * @return void
     */
    public static function getInstance() {
        return new self();
    }

}