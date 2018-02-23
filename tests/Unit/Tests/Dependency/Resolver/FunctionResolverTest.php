<?php

namespace uSIreF\AutoWire\Unit\Tests\Dependency\Resolver;

use uSIreF\AutoWire\Unit\Abstracts\TestCase;
use uSIreF\AutoWire\Dependency\Resolver\{FunctionResolver, Definition};
use uSIreF\AutoWire\Dependency\Exception;
use stdClass;

/**
 * This file defines test class for resolver Function.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class FunctionResolverTest extends TestCase {

    /**
     * Fail test for non exist function.
     *
     * @return void
     */
    public function testNonExistFunction() {
        $resolver = new FunctionResolver();

        $this->expectException(Exception::class);
        $resolver->resolve(__NAMESPACE__.'_someUndefinedFunction');
    }

    /**
     * Success test for simpleTestFunction.
     *
     * @return void
     */
    public function testSimpleFunction() {
        $resolver  = new FunctionResolver();
        $arguments = $resolver->resolve(__NAMESPACE__.'\\simpleTestFunction');

        $this->assertInstanceOf(Definition::class, $arguments);
        $this->assertEquals(Definition::TYPE_FUNCTION, $arguments->getType());
        $this->assertInternalType('array', $arguments->getParameters());
        $this->assertCount(0, $arguments->getParameters());
    }

    /**
     * Success test for functionWithArguments.
     *
     * @return void
     */
    public function testFunctionWithArguments() {
        $resolver  = new FunctionResolver();
        $arguments = $resolver->resolve(__NAMESPACE__.'\\functionWithArguments');

        $this->assertInstanceOf(Definition::class, $arguments);
        $this->assertEquals(Definition::TYPE_FUNCTION, $arguments->getType());
        $this->assertInternalType('array', $arguments->getParameters());
        $this->assertCount(6, $arguments->getParameters());

        $expected = [
            'name'     => ['nonType', 'bool', 'int', 'string', 'array', 'stdClass'],
            'type'     => [null, 'bool', 'int', 'string', 'array', 'stdClass'],
            'optional' => [false, false, false, false, false, false],
            'default'  => [null, null, null, null, null, null],
        ];

        foreach ($expected as $type => $expectedType) {
            foreach ($arguments->getParameters() as $index => $param) { /* @var $param Param */
                $this->assertSame($expectedType[$index], $param->{$type});
            }
        }
    }

    /**
     * Success test for functionWithDefaults.
     *
     * @return void
     */
    public function testFunctionWithDefaults() {
        $resolver  = new FunctionResolver();
        $arguments = $resolver->resolve(__NAMESPACE__.'\\functionWithDefaults');

        $this->assertInstanceOf(Definition::class, $arguments);
        $this->assertEquals(Definition::TYPE_FUNCTION, $arguments->getType());
        $this->assertInternalType('array', $arguments->getParameters());
        $this->assertCount(5, $arguments->getParameters());

        $expected = [
            'name'     => ['nonType', 'bool', 'int', 'string', 'array'],
            'type'     => [null, 'bool', 'int', 'string', 'array'],
            'optional' => [true, true, true, true, true],
            'default'  => ['yes', true, 4, 'string', []],
        ];

        foreach ($expected as $type => $expectedType) {
            foreach ($arguments->getParameters() as $index => $param) { /* @var $param Param */
                $this->assertSame($expectedType[$index], $param->{$type});
            }
        }
    }

    /**
     * Success test for functionWithDefaultsNull.
     *
     * @return void
     */
    public function testFunctionWithDefaultsNull() {
        $resolver = new FunctionResolver();
        $arguments = $resolver->resolve(__NAMESPACE__.'\\functionWithDefaultsNull');

        $this->assertInstanceOf(Definition::class, $arguments);
        $this->assertEquals(Definition::TYPE_FUNCTION, $arguments->getType());
        $this->assertInternalType('array', $arguments->getParameters());
        $this->assertCount(5, $arguments->getParameters());

        $expected = [
            'name'     => ['nonType', 'bool', 'int', 'string', 'array'],
            'type'     => [null, 'bool', 'int', 'string', 'array'],
            'optional' => [true, true, true, true, true],
            'default'  => [null, null, null, null, null],
        ];

        foreach ($expected as $type => $expectedType) {
            foreach ($arguments->getParameters() as $index => $param) { /* @var $param Param */
                $this->assertSame($expectedType[$index], $param->{$type});
            }
        }
    }

}

/**
 * Simple function for test without any argumetns.
 *
 * @return null
 */
function simpleTestFunction() {
    return null;
}

/**
 * Function for test with basic types arguments.
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
function functionWithArguments($nonType, bool $bool, int $int, string $string, array $array, stdClass $stdClass) {
    return [$nonType, $bool, $int, $string, $array, $stdClass];
}

/**
 * Function for test with basic types arguments and valid default values.
 *
 * @param mixed  $nonType Argument without type
 * @param bool   $bool    Boolean
 * @param int    $int     Integer
 * @param string $string  String
 * @param array  $array   Array
 *
 * @return array
 */
function functionWithDefaults($nonType = 'yes', bool $bool = true, int $int = 4, string $string = 'string', array $array = []) {
    return [$nonType, $bool, $int, $string, $array];
}

/**
 * Function for test with basic types arguments and valid null values.
 *
 * @param mixed  $nonType Argument without type
 * @param bool   $bool    Boolean
 * @param int    $int     Integer
 * @param string $string  String
 * @param array  $array   Array
 *
 * @return array
 */
function functionWithDefaultsNull($nonType = null, bool $bool = null, int $int = null, string $string = null, array $array = null) {
    return [$nonType, $bool, $int, $string, $array];
}