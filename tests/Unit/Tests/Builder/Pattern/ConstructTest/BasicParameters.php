<?php

namespace uSIreF\AutoWire\Unit\Tests\Builder\Pattern\ConstructTest;

/**
 * This file defines class for testing construct creator.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class BasicParameters {

    /**
     * Testing constructor with basic types.
     *
     * @param mixed  $nonType Non-type
     * @param bool   $boolean Boolean
     * @param int    $integer Integer
     * @param string $string  String
     * @param array  $array   Array
     *
     * @return void
     */
    public function __construct($nonType, bool $boolean, int $integer, string $string, array $array) {
        return [$nonType, $boolean, $integer, $string, $array];
    }

}