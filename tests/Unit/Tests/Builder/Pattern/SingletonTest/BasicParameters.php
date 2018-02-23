<?php

namespace uSIreF\AutoWire\Unit\Tests\Builder\Pattern\SingletonTest;

/**
 * This file defines class for testing singleton creator.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class BasicParameters {

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
    public static function getInstance($nonType, bool $boolean, int $integer, string $string, array $array) {
        return new self([$nonType, $boolean, $integer, $string, $array]);
    }

}