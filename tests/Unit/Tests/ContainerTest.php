<?php

namespace uSIreF\AutoWire\Unit\Tests;

use uSIreF\AutoWire\Unit\Abstracts\TestCase;
use uSIreF\AutoWire\{Container, Exception};

use stdClass;

/**
 * This file defines test class for Container.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class ContainerTest extends TestCase {

    /**
     * Test for method get.
     *
     * @return void
     */
    public function testGet() {
        $container = new Container();

        $this->assertNull($container->get('test'));
        $container->set('string', 'test');
        $this->assertEquals('string', $container->get('test'));

        $container->set(new stdClass(), 'std');
        $this->assertInstanceOf(stdClass::class, $container->get(stdClass::class));
    }

    /**
     * Test for method has.
     *
     * @return void
     */
    public function testHas() {
        $container = new Container();

        $this->assertFalse($container->has('test'));
        $container->set(false, 'test');
        $this->assertTrue($container->has('test'));

        $container->set(new stdClass(), 'std');
        $this->assertTrue($container->has(stdClass::class));
    }

    /**
     * Test for method set.
     *
     * @return void
     */
    public function testSet() {
        $container = new Container();

        $this->assertNull($container->get('test'));
        $container->set('string', 'test');
        $this->assertEquals('string', $container->get('test'));

        $this->assertNull($container->get(stdClass::class));
        $container->set(new stdClass());
        $this->assertInstanceOf(stdClass::class, $container->get(stdClass::class));

        $this->expectException(Exception::class);
        $container->set('string');
    }

    /**
     * Test for method reset.
     *
     * @return void
     */
    public function testReset() {
        $container = new Container();

        $this->assertNull($container->get('test'));
        $container->set('string', 'test');
        $this->assertEquals('string', $container->get('test'));
        $container->reset('test');
        $this->assertNull($container->get('test'));
    }

}