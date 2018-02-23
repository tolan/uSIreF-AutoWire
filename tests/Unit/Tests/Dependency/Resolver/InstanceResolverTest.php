<?php

namespace uSIreF\AutoWire\Unit\Tests\Dependency\Resolver;

use uSIreF\AutoWire\Unit\Abstracts\TestCase;
use uSIreF\AutoWire\Unit\Tests\Dependency\ResolverTest\{SimpleTestClassWithoutMethod, SimpleTestClass, SimpleTestClassPrivate, ComplexTestClass};
use uSIreF\AutoWire\Dependency\Resolver\{InstanceResolver, Definition};
use uSIreF\AutoWire\Dependency\Exception;

/**
 * This file defines test class for resolver Instance.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class InstanceResolverTest extends TestCase {

    /**
     * Fail test for non exists class.
     *
     * @return void
     */
    public function testClassDoesNotExist() {
        $this->expectException(Exception::class);
        new InstanceResolver(__NAMESPACE__.'\\NotExistClass');
    }

    /**
     * Success test for SimpleTestClassWithoutMethod.
     *
     * @return void
     */
    public function testSimpleClassWithoutMethod() {
        $resolver = new InstanceResolver(SimpleTestClassWithoutMethod::class);

        $this->assertInstanceOf(Definition::class, $resolver->resolve());
        $this->assertEquals(Definition::TYPE_PUBLIC_METHOD, $resolver->resolve()->getType());
        $this->assertInstanceOf(Definition::class, $resolver->resolve('__construct'));
        $this->assertEquals(Definition::TYPE_PUBLIC_METHOD, $resolver->resolve('__construct')->getType());
    }

    /**
     * Fail test for undefined method of SimpleTestClassWithoutMethod.
     *
     * @return void
     */
    public function testSimpleClassWithoutMethodFail() {
        $resolver = new InstanceResolver(SimpleTestClassWithoutMethod::class);

        $this->expectException(Exception::class);
        $resolver->resolve('undefined');
    }

    /**
     * Success test for SimpleTestClass.
     *
     * @return void
     */
    public function testSimpleClassConstructMethod() {
        $resolver = new InstanceResolver(SimpleTestClass::class);

        $this->assertInstanceOf(Definition::class, $resolver->resolve());
        $this->assertEquals(Definition::TYPE_PUBLIC_METHOD, $resolver->resolve()->getType());
        $this->assertInstanceOf(Definition::class, $resolver->resolve('__construct'));
        $this->assertEquals(Definition::TYPE_PUBLIC_METHOD, $resolver->resolve('__construct')->getType());
    }

    /**
     * Success test for SimpleTestClassPrivate.
     *
     * @return void
     */
    public function testSimpleClassPrivateConstruct() {
        $resolver  = new InstanceResolver(SimpleTestClassPrivate::class);
        $arguments = $resolver->resolve();

        $this->assertInstanceOf(Definition::class, $arguments);
        $this->assertEquals(Definition::TYPE_PRIVATE_METHOD, $arguments->getType());
    }

    /**
     * Success test for ComplexTestClass::withArguments.
     *
     * @return void
     */
    public function testComplextClassWithArguments() {
        $resolver  = new InstanceResolver(ComplexTestClass::class);
        $arguments = $resolver->resolve('withArguments');

        $this->assertInstanceOf(Definition::class, $arguments);
        $this->assertEquals(Definition::TYPE_PUBLIC_METHOD, $arguments->getType());
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
     * Success test for ComplexTestClass::withDefaults.
     *
     * @return void
     */
    public function testComplextClassWithDefaults() {
        $resolver  = new InstanceResolver(ComplexTestClass::class);
        $arguments = $resolver->resolve('withDefaults');

        $this->assertInstanceOf(Definition::class, $arguments);
        $this->assertEquals(Definition::TYPE_PUBLIC_METHOD, $arguments->getType());
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
     * Success test for ComplexTestClass::withDefaultsNull.
     *
     * @return void
     */
    public function testComplextClassWithDefaultsNull() {
        $resolver = new InstanceResolver(ComplexTestClass::class);
        $arguments = $resolver->resolve('withDefaultsNull');

        $this->assertInstanceOf(Definition::class, $arguments);
        $this->assertEquals(Definition::TYPE_PUBLIC_METHOD, $arguments->getType());
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

    /**
     * Success test for ComplexTestClass::protectedFunction.
     *
     * @return void
     */
    public function testComplexClassProtectedMethod() {
        $resolver  = new InstanceResolver(ComplexTestClass::class);
        $arguments = $resolver->resolve('protectedFunction');

        $this->assertInstanceOf(Definition::class, $arguments);
        $this->assertEquals(Definition::TYPE_PROTECTED_METHOD, $arguments->getType());
    }

    /**
     * Success test for ComplexTestClass::_privateFunction.
     *
     * @return void
     */
    public function testComplexClassPrivateMethod() {
        $resolver  = new InstanceResolver(ComplexTestClass::class);
        $arguments = $resolver->resolve('_privateFunction');

        $this->assertInstanceOf(Definition::class, $arguments);
        $this->assertEquals(Definition::TYPE_PRIVATE_METHOD, $arguments->getType());
    }

    /**
     * Success test for ComplexTestClass::publicStaticFunction.
     *
     * @return void
     */
    public function testComplexClassPublicStatic() {
        $resolver  = new InstanceResolver(ComplexTestClass::class);
        $arguments = $resolver->resolve('publicStaticFunction');

        $this->assertInstanceOf(Definition::class, $arguments);
        $this->assertEquals(Definition::TYPE_STATIC_PUBLIC_METHOD, $arguments->getType());
    }

    /**
     * Success test for ComplexTestClass::protectedStaticFunction.
     *
     * @return void
     */
    public function testComplexClassProtectedStatic() {
        $resolver  = new InstanceResolver(ComplexTestClass::class);
        $arguments = $resolver->resolve('protectedStaticFunction');

        $this->assertInstanceOf(Definition::class, $arguments);
        $this->assertEquals(Definition::TYPE_STATIC_PROTECTED_METHOD, $arguments->getType());
    }

    /**
     * Success test for ComplexTestClass::_privateStaticFunction.
     *
     * @return void
     */
    public function testComplexClassPrivateStatic() {
        $resolver  = new InstanceResolver(ComplexTestClass::class);
        $arguments = $resolver->resolve('_privateStaticFunction');

        $this->assertInstanceOf(Definition::class, $arguments);
        $this->assertEquals(Definition::TYPE_STATIC_PRIVATE_METHOD, $arguments->getType());
    }

}