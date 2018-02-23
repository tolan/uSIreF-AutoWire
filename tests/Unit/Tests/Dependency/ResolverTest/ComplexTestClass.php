<?php

namespace uSIreF\AutoWire\Unit\Tests\Dependency\ResolverTest;

use stdClass;

/**
 * Complex class for tests with different methods.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class ComplexTestClass {

    /**
     * Method for test with basic types arguments.
     *
     * @param mixed    $nonType  Argument without type
     * @param bool     $bool     Boolean
     * @param int      $int      Integer
     * @param string   $string   String
     * @param array    $array    Array
     * @param stdClass $stdClass stdClass
     *
     * @return array
     */
    public function withArguments($nonType, bool $bool, int $int, string $string, array $array, stdClass $stdClass) {
        return [$nonType, $bool, $int, $string, $array, $stdClass];
    }

    /**
     * Method for test with basic types arguments with valid default values.
     *
     * @param mixed  $nonType Argument without type
     * @param bool   $bool    Boolean
     * @param int    $int     Integer
     * @param string $string  String
     * @param array  $array   Array
     *
     * @return array
     */
    public function withDefaults($nonType = 'yes', bool $bool = true, int $int = 4, string $string = 'string', array $array = []) {
        return [$nonType, $bool, $int, $string, $array];
    }

    /**
     * Method for test with basic types arguments with null default values.
     *
     * @param mixed  $nonType Argument without type
     * @param bool   $bool    Boolean
     * @param int    $int     Integer
     * @param string $string  String
     * @param array  $array   Array
     *
     * @return array
     */
    public function withDefaultsNull($nonType = null, bool $bool = null, int $int = null, string $string = null, array $array = null) {
        return [$nonType, $bool, $int, $string, $array];
    }

    /**
     * Method for test with protected visibility.
     *
     * @return void
     */
    protected function protectedFunction() {
        $this->_privateFunction();
    }

    /**
     * Method for test with private visibility.
     *
     * @return void
     */
    private function _privateFunction() {
    }

    /**
     * Method for test with static visibility.
     *
     * @return void
     */
    public static function publicStaticFunction() {
    }

    /**
     * Method for test with static protected visibility.
     *
     * @return void
     */
    protected static function protectedStaticFunction() {
        self::_privateStaticFunction();
    }

    /**
     * Method for test with static private visibility.
     *
     * @return void
     */
    private static function _privateStaticFunction() {
    }
}