<?php

namespace uSIreF\AutoWire\Unit\Tests\Builder\Pattern;

use uSIreF\AutoWire\Unit\Abstracts\TestCase;
use uSIreF\AutoWire\Provider;
use uSIreF\AutoWire\Builder\Exception;
use uSIreF\AutoWire\Builder\Pattern\Singleton;
use uSIreF\AutoWire\Dependency\{Collector, Resolver};

use uSIreF\AutoWire\Unit\Tests\Builder\Pattern\SingletonTest\{
    BasicParameters, BasicWithDefaults, NonSingleton, ProtectedSingleton, SimpleClass, WithDependencies
};

use stdClass, ArrayObject;

/**
 * This file defines test class for Singleton creator.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class SingletonTest extends TestCase {

    /**
     * Test for method match.
     *
     * @return void
     */
    public function testMatch() {
        $creator = new Singleton();
        $this->assertTrue($creator->match(BasicParameters::class));
        $this->assertTrue($creator->match(BasicWithDefaults::class));
        $this->assertFalse($creator->match(NonSingleton::class));
        $this->assertFalse($creator->match(ProtectedSingleton::class));
        $this->assertTrue($creator->match(SimpleClass::class));
        $this->assertTrue($creator->match(WithDependencies::class));
    }

    /**
     * Fail test for create instance via protected singleton method.
     *
     * @return void
     */
    public function testCreateProtectedMethod() {
        $this->expectException(Exception::class);
        $this->_createInstance(ProtectedSingleton::class);
    }

    /**
     * Fail test for create instance without singleton method.
     *
     * @return void
     */
    public function testCreateNonSingleton() {
        $this->expectException(Exception::class);
        $this->_createInstance(NonSingleton::class);
    }

    /**
     * Success test for create instances via simple singleton method.
     *
     * @return void
     */
    public function testCreateInstance() {
        $this->assertInstanceOf(SimpleClass::class, $this->_createInstance(SimpleClass::class));
        $this->assertInstanceOf(BasicWithDefaults::class, $this->_createInstance(BasicWithDefaults::class));
    }

    /**
     * Success test for create instance via singleton method without default values.
     *
     * @return void
     */
    public function testCreateBasicParameters() {
        $provider = new Provider();
        $provider
            ->set(null, 'nonType')
            ->set(true, 'boolean')
            ->set(2, 'integer')
            ->set('some string', 'string')
            ->set([], 'array');

        $this->assertInstanceOf(BasicParameters::class, $this->_createInstance(BasicParameters::class, null, $provider));
    }

    /**
     * Success test for create instance via singleton method with instance dependencies.
     *
     * @return void
     */
    public function testCreateWithDependencies() {
        $provider = new Provider();
        $provider
            ->set(null, 'required')
            ->set(new stdClass(), 'withoutDefault');

        $this->assertInstanceOf(WithDependencies::class, $this->_createInstance(WithDependencies::class, null, $provider));

        $provider->set(new ArrayObject([]), 'withDefault');
        $this->assertInstanceOf(WithDependencies::class, $this->_createInstance(WithDependencies::class, null, $provider));

        $provider->set('invalidType', 'ArrayObject');
        $this->expectException(Exception::class);
        $this->assertInstanceOf(WithDependencies::class, $this->_createInstance(WithDependencies::class, null, $provider));
    }

    /**
     * Helper method for create insntance.
     *
     * @param string    $className Class name
     * @param Collector $collector Collector instance (optional)
     * @param Provider  $provider  Provider instance (optional)
     *
     * @return object
     */
    private function _createInstance($className, Collector $collector = null, Provider $provider = null) {
        $construct = new Singleton();
        $collector = ($collector ?? new Collector(new Resolver()));
        $provider  = ($provider ?? new Provider());

        return $construct->create($className, $collector, $provider);
    }

}