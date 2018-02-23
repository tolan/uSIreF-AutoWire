<?php

namespace uSIreF\AutoWire\Unit\Tests\Builder\Pattern;

use uSIreF\AutoWire\Unit\Abstracts\TestCase;
use uSIreF\AutoWire\Provider;
use uSIreF\AutoWire\Builder\Exception;
use uSIreF\AutoWire\Builder\Pattern\Construct;
use uSIreF\AutoWire\Dependency\{Collector, Resolver};

use uSIreF\AutoWire\Unit\Tests\Builder\Pattern\ConstructTest\{
    BasicParameters, BasicWithDefaults, PrivateConstruct, SimpleClass, WithDependencies, WithoutConstruct
};

use stdClass, ArrayObject;

/**
 * This file defines test class for Construct creator.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class ConstructTest extends TestCase {

    /**
     * Test for method match.
     *
     * @return void
     */
    public function testMatch() {
        $creator = new Construct();
        $this->assertTrue($creator->match(BasicParameters::class));
        $this->assertTrue($creator->match(BasicWithDefaults::class));
        $this->assertFalse($creator->match(PrivateConstruct::class));
        $this->assertTrue($creator->match(SimpleClass::class));
        $this->assertTrue($creator->match(WithDependencies::class));
        $this->assertTrue($creator->match(WithoutConstruct::class));
    }

    /**
     * Fail test for create instance via private construct.
     *
     * @return void
     */
    public function testCreatePrivateConstruct() {
        $this->expectException(Exception::class);
        $this->_createInstance(PrivateConstruct::class);
    }

    /**
     * Success test for create instances via simple construct.
     *
     * @return void
     */
    public function testCreateInstance() {
        $this->assertInstanceOf(SimpleClass::class, $this->_createInstance(SimpleClass::class));
        $this->assertInstanceOf(WithoutConstruct::class, $this->_createInstance(WithoutConstruct::class));
        $this->assertInstanceOf(BasicWithDefaults::class, $this->_createInstance(BasicWithDefaults::class));
    }

    /**
     * Success test for create instance via constuct without default values.
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
     * Success test for create instance via constuct with instance dependencies.
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
     * Fail test for create instance. It fails because the class requires arguments which can't be resolved.
     *
     * @return void
     */
    public function testCreateWithoutResolveableParameter() {
        $this->expectException(Exception::class);
        $this->assertInstanceOf(WithDependencies::class, $this->_createInstance(WithDependencies::class));
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
    private function _createInstance(string $className, Collector $collector = null, Provider $provider = null) {
        $construct = new Construct();
        $collector = ($collector ?? new Collector(new Resolver()));
        $provider  = ($provider ?? new Provider());

        return $construct->create($className, $collector, $provider);
    }
}