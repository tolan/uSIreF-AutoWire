<?php

namespace uSIreF\AutoWire\Unit\Tests\Dependency;

use uSIreF\AutoWire\Unit\Abstracts\TestCase;
use uSIreF\AutoWire\Unit\Tests\Dependency\ResolverTest\SimpleTestClass;
use uSIreF\AutoWire\Dependency\{Resolver, Exception, Resolver\Definition};

/**
 * This file defines test class for Resolver.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class ResolverTest extends TestCase {

    /**
     * Fail test for non exist function.
     *
     * @return void
     */
    public function testNonExistFunction() {
        $resolver = new Resolver();

        $this->expectException(Exception::class);
        $resolver->resolve(__NAMESPACE__.'_someUndefinedFunction');
    }

    /**
     * Success test for simpleTestFunction.
     *
     * @return void
     */
    public function testSimpleFunction() {
        $resolver  = new Resolver();
        $arguments = $resolver->resolve(__NAMESPACE__.'\\Resolver\\simpleTestFunction');

        $this->assertInstanceOf(Definition::class, $arguments);
        $this->assertEquals(Definition::TYPE_FUNCTION, $arguments->getType());
        $this->assertInternalType('array', $arguments->getParameters());
        $this->assertCount(0, $arguments->getParameters());
    }

    /**
     * Success test for SimpleTestClass.
     *
     * @return void
     */
    public function testSimpleClassConstructMethod() {
        $resolver  = new Resolver();
        $className = SimpleTestClass::class;

        $this->assertInstanceOf(Definition::class, $resolver->resolve($className));
        $this->assertEquals(Definition::TYPE_PUBLIC_METHOD, $resolver->resolve($className)->getType());
        $this->assertInstanceOf(Definition::class, $resolver->resolve($className, '__construct'));
        $this->assertEquals(Definition::TYPE_PUBLIC_METHOD, $resolver->resolve($className, '__construct')->getType());
    }

    /**
     * Success test for SimpleTestClass.
     *
     * @return void
     */
    public function testSimpleClassWithDoubleDoubleDots() {
        $resolver  = new Resolver();
        $arguments = $resolver->resolve(SimpleTestClass::class.'::__construct');

        $this->assertInstanceOf(Definition::class, $arguments);
        $this->assertEquals(Definition::TYPE_PUBLIC_METHOD, $arguments->getType());
    }

}