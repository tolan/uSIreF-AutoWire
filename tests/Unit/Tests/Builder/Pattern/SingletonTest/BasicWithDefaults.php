<?php

namespace uSIreF\AutoWire\Unit\Tests\Builder\Pattern\SingletonTest;

/**
 * This file defines class for testing singleton creator.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class BasicWithDefaults {

    /**
     * Testing singleton with basic types.
     *
     * @param mixed  $nonType Non-type
     * @param bool   $boolean Boolean
     * @param int    $integer Integer
     * @param string $string  String
     * @param array  $array   Array
     *
     * @return void
     */
    public static function getInstance($nonType = null, bool $boolean = true, int $integer = 5, string $string = 'some string', array $array = [9]) {
        return new self([$nonType, $boolean, $integer, $string, $array]);
    }

}