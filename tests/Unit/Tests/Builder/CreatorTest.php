<?php

namespace uSIreF\AutoWire\Unit\Tests\Builder;

use uSIreF\AutoWire\Unit\Abstracts\TestCase;
use uSIreF\AutoWire\Builder\{Creator, Exception};
use uSIreF\AutoWire\Provider;
use uSIreF\AutoWire\Dependency\{Collector, Resolver};
use uSIreF\AutoWire\Unit\Tests\Builder\Pattern\{ConstructTest, SingletonTest};
use stdClass, ArrayObject;

/**
 * This file defines test class for Creator.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class CreatorTest extends TestCase {

    /**
     * Success test for method create.
     *
     * @return void
     */
    public function testCreate() {
        $provider = new Provider();
        $provider
            ->set(null, 'required')
            ->set(null, 'nonType')
            ->set(true, 'boolean')
            ->set(2, 'integer')
            ->set('some string', 'string')
            ->set([], 'array')
            ->set(new stdClass(), 'withoutDefault');

        $creator = $this->_createCreator($provider);

        $this->assertInstanceOf(stdClass::class, $creator->create(stdClass::class));
        $this->assertInstanceOf(ArrayObject::class, $creator->create(ArrayObject::class));
        $this->assertInstanceOf(ConstructTest\BasicParameters::class, $creator->create(ConstructTest\BasicParameters::class));
        $this->assertInstanceOf(ConstructTest\BasicWithDefaults::class, $creator->create(ConstructTest\BasicWithDefaults::class));
        $this->assertInstanceOf(ConstructTest\SimpleClass::class, $creator->create(ConstructTest\SimpleClass::class));
        $this->assertInstanceOf(ConstructTest\WithDependencies::class, $creator->create(ConstructTest\WithDependencies::class));
        $this->assertInstanceOf(ConstructTest\WithoutConstruct::class, $creator->create(ConstructTest\WithoutConstruct::class));

        $this->assertInstanceOf(SingletonTest\BasicParameters::class, $creator->create(SingletonTest\BasicParameters::class));
        $this->assertInstanceOf(SingletonTest\BasicWithDefaults::class, $creator->create(SingletonTest\BasicWithDefaults::class));
        $this->assertInstanceOf(SingletonTest\SimpleClass::class, $creator->create(SingletonTest\SimpleClass::class));
        $this->assertInstanceOf(SingletonTest\WithDependencies::class, $creator->create(SingletonTest\WithDependencies::class));
        $this->assertInstanceOf(SingletonTest\ProtectedSingleton::class, $creator->create(SingletonTest\ProtectedSingleton::class));
        $this->assertInstanceOf(SingletonTest\NonSingleton::class, $creator->create(SingletonTest\NonSingleton::class));
    }

    /**
     * Fail test for method create. It fails because consturct is not accessible.
     *
     * @return void
     */
    public function testCreateFailPrivateConstructor() {
        $this->expectException(Exception::class);
        $this->_createCreator()->create(ConstructTest\PrivateConstruct::class);
    }

    /**
     * Helper method for create Creator instance.
     *
     * @param Provider $provider Provider instance
     *
     * @return Creator
     */
    private function _createCreator(Provider $provider = null): Creator {
        $provider = ($provider ?? new Provider());
        return new Creator(new Collector(new Resolver()), $provider);
    }

}