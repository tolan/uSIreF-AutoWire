<?php

namespace uSIreF\AutoWire\Unit\Tests\Builder;

use uSIreF\AutoWire\Unit\Abstracts\TestCase;
use uSIreF\AutoWire\Builder\Finder;
use uSIreF\AutoWire\Unit\Tests\Builder\Pattern\{ConstructTest, SingletonTest};
use uSIreF\AutoWire\Builder\Pattern\{Construct, Singleton};
use stdClass, ArrayObject;

/**
 * This file defines test class for Finder.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class FinderTest extends TestCase {

    /**
     * Success test for mtehod findPattern.
     *
     * @return void
     */
    public function testFind() {
        $finder = new Finder();
        $this->assertNull($finder->findPattern(ConstructTest\PrivateConstruct::class));
        $this->assertInstanceOf(Construct::class, $finder->findPattern(stdClass::class));
        $this->assertInstanceOf(Construct::class, $finder->findPattern(ArrayObject::class));
        $this->assertInstanceOf(Construct::class, $finder->findPattern(ConstructTest\BasicParameters::class));
        $this->assertInstanceOf(Construct::class, $finder->findPattern(ConstructTest\BasicWithDefaults::class));
        $this->assertInstanceOf(Construct::class, $finder->findPattern(ConstructTest\SimpleClass::class));
        $this->assertInstanceOf(Construct::class, $finder->findPattern(ConstructTest\WithDependencies::class));
        $this->assertInstanceOf(Construct::class, $finder->findPattern(ConstructTest\WithoutConstruct::class));
        $this->assertInstanceOf(Singleton::class, $finder->findPattern(SingletonTest\BasicParameters::class));
        $this->assertInstanceOf(Singleton::class, $finder->findPattern(SingletonTest\BasicWithDefaults::class));
        $this->assertInstanceOf(Construct::class, $finder->findPattern(SingletonTest\NonSingleton::class));
        $this->assertInstanceOf(Construct::class, $finder->findPattern(SingletonTest\ProtectedSingleton::class));
        $this->assertInstanceOf(Singleton::class, $finder->findPattern(SingletonTest\SimpleClass::class));
        $this->assertInstanceOf(Singleton::class, $finder->findPattern(SingletonTest\WithDependencies::class));
    }

    /**
     * Fail test for method findPattern.
     *
     * @return void
     */
    public function testFindFail() {
        $this->expectException(\TypeError::class);
        (new Finder())->findPattern(['wrong type']);
    }

}