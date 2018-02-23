<?php

namespace uSIreF\AutoWire\Unit\Tests;

use uSIreF\AutoWire\Unit\Abstracts\TestCase;
use uSIreF\AutoWire\{Provider, Exception};
use stdClass;

/**
 * This file defines test class for Provider.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class ProviderTest extends TestCase {

    /**
     * Success test for method get.
     *
     * @return void
     */
    public function testGet() {
        $provider = new Provider();

        $this->assertInstanceOf(stdClass::class, $provider->get(stdClass::class));
        $this->assertInstanceOf(ProviderTest\DependencyL3::class, $provider->get(ProviderTest\DependencyL3::class));
    }

    /**
     * Success test for method has.
     *
     * @return void
     */
    public function testHas() {
        $provider = new Provider();

        $this->assertFalse($provider->has(stdClass::class));
        $provider->get(stdClass::class);
        $this->assertTrue($provider->has(stdClass::class));
    }

    /**
     * Success test for method set.
     *
     * @return void
     */
    public function testSet() {
        $provider = new Provider();

        $this->assertFalse($provider->has(stdClass::class));
        $provider->set(new stdClass());
        $this->assertTrue($provider->has(stdClass::class));
    }

    /**
     * Success test for method reset.
     *
     * @return void
     */
    public function testReset() {
        $provider = new Provider();

        $provider->set(new stdClass());
        $this->assertTrue($provider->has(stdClass::class));
        $provider->reset(stdClass::class);
        $this->assertFalse($provider->has(stdClass::class));
    }

    /**
     * Success test for method prototype.
     *
     * @return void
     */
    public function testPrototype() {
        $provider = new Provider();
        $instance = $provider->get(ProviderTest\PrototypeDeep::class);

        $this->assertSame($instance, $provider->get(ProviderTest\PrototypeDeep::class));
        $this->assertSame($instance->dep, $provider->get(ProviderTest\PrototypeDeep::class)->dep);
        $this->assertNotSame($instance, $provider->prototype(ProviderTest\PrototypeDeep::class));
        $this->assertSame($instance->dep, $provider->prototype(ProviderTest\PrototypeDeep::class)->dep);
        $this->assertNotSame($instance, $provider->prototype(ProviderTest\PrototypeDeep::class, true));
        $this->assertFalse($instance->dep === $provider->prototype(ProviderTest\PrototypeDeep::class, true)->dep);
    }

    /**
     * Fail test for method get. It fails because required class has cycling dependency.
     *
     * @return void
     */
    public function testGetCyclingSelf() {
        $provider = new Provider();

        $this->expectException(Exception::class);
        $provider->get(ProviderTest\Cycling::class);
    }

    /**
     * Fail test for method get. It fails because required class has cycling dependency.
     *
     * @return void
     */
    public function testGetCyclingTwo() {
        $provider = new Provider();

        $this->expectException(Exception::class);
        $provider->get(ProviderTest\CyclingA::class);
    }

}