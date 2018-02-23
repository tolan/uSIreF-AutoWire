<?php

namespace uSIreF\AutoWire\Unit\Tests\Dependency\Resolver;

use uSIreF\AutoWire\Unit\Abstracts\TestCase;
use uSIreF\AutoWire\Dependency\Resolver\Parameter;
use stdClass;
use ReflectionParameter;

/**
 * This file defines test class for resolver Parameter.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class ParameterTest extends TestCase {

    /**
     * Success test for method load.
     *
     * @return void
     */
    public function testLoadNonType() {
        $reflection = new ReflectionParameter(__NAMESPACE__.'\\parameterTestFunction', 'nonType');
        $parameter  = new Parameter($reflection);

        $this->assertEquals('nonType', $parameter->name);
        $this->assertEquals(0, $parameter->position);
        $this->assertEquals(null, $parameter->type);
        $this->assertFalse($parameter->optional);
        $this->assertEquals(null, $parameter->default);
        $this->assertFalse($parameter->isClass);
    }

    /**
     * Success test for method load.
     *
     * @return void
     */
    public function testLoadStdClass() {
        $reflection = new ReflectionParameter(__NAMESPACE__.'\\parameterTestFunction', 'class');
        $parameter  = new Parameter($reflection);

        $this->assertEquals('class', $parameter->name);
        $this->assertEquals(1, $parameter->position);
        $this->assertEquals(stdClass::class, $parameter->type);
        $this->assertFalse($parameter->optional);
        $this->assertEquals(null, $parameter->default);
        $this->assertTrue($parameter->isClass);
    }

    /**
     * Success test for method load.
     *
     * @return void
     */
    public function testLoadArgOne() {
        $reflection = new ReflectionParameter(__NAMESPACE__.'\\parameterTestFunction', 'argOne');
        $parameter  = new Parameter($reflection);

        $this->assertEquals('argOne', $parameter->name);
        $this->assertEquals(2, $parameter->position);
        $this->assertEquals('string', $parameter->type);
        $this->assertTrue($parameter->optional);
        $this->assertEquals('default', $parameter->default);
        $this->assertFalse($parameter->isClass);
    }

}

/**
 * Simple function for load test.
 *
 * @param mixed    $nonType Test argument
 * @param stdClass $class   Test argument
 * @param string   $argOne  Test argument
 *
 * @return array
 */
function parameterTestFunction($nonType, stdClass $class, string $argOne = 'default') {
    return [$nonType, $argOne, $class];
}