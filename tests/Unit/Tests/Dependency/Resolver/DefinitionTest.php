<?php

namespace uSIreF\AutoWire\Unit\Tests\Dependency\Resolver;

use uSIreF\AutoWire\Unit\Abstracts\TestCase;
use uSIreF\AutoWire\Dependency\Resolver\{Definition, Parameter};
use uSIreF\AutoWire\Dependency\Exception;
use ReflectionParameter;

/**
 * This file defines test class for resolver Method.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class DefinitionTest extends TestCase {

    /**
     * Success test for available types.
     *
     * @return void
     */
    public function testCreateAndGeTypeMethodSuccess() {
        $availableTypes = [
            Definition::TYPE_FUNCTION,
            Definition::TYPE_PUBLIC_METHOD,
            Definition::TYPE_PROTECTED_METHOD,
            Definition::TYPE_PRIVATE_METHOD,
            Definition::TYPE_STATIC_PUBLIC_METHOD,
            Definition::TYPE_STATIC_PROTECTED_METHOD,
            Definition::TYPE_STATIC_PRIVATE_METHOD,
        ];

        foreach ($availableTypes as $type) {
            $this->assertEquals($type, (new Definition('name', $type))->getType());
        }
    }

    /**
     * Success test for method getName.
     *
     * @return void
     */
    public function testGetName() {
        $representation = new Definition('name', Definition::TYPE_FUNCTION);
        $this->assertEquals('name', $representation->getName());
    }

    /**
     * Fail test for unsupported type.
     *
     * @return void
     */
    public function testCreateMethodFail() {
        $this->expectException(Exception::class);
        new Definition('some string because it is valid', 'unsupported type');
    }

    /**
     * Success test for add method.
     *
     * @return void
     */
    public function testAdd() {
        $method = new Definition('name', Definition::TYPE_FUNCTION);

        $this->assertInstanceOf(Definition::class, $method->add(new Parameter(new ReflectionParameter('is_int', 'var'))));
    }

    /**
     * Success test for method get parameters.
     *
     * @return void
     */
    public function testGetParameters() {
        $method = new Definition('name', Definition::TYPE_FUNCTION);
        $this->assertCount(0, $method->getParameters());

        $method->add(new Parameter(new ReflectionParameter('is_int', 'var')));
        $this->assertCount(1, $method->getParameters());

        $method->add(new Parameter(new ReflectionParameter('is_int', 'var')));
        $this->assertCount(2, $method->getParameters());
    }

}