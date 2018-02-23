<?php

namespace uSIreF\AutoWire\Unit\Tests\Dependency;

use uSIreF\AutoWire\Unit\Abstracts\TestCase;
use uSIreF\AutoWire\Dependency\{Resolver, Collector, Resolver\Definition};

/**
 * This file defines test class for Collector.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class CollectorTest extends TestCase {

    /**
     * Success test for method get.
     *
     * @return void
     */
    public function testGet() {
        $mock           = $this->createMock(Resolver::class);
        $representation = new Definition('name', Definition::TYPE_FUNCTION);

        $mock->expects($this->exactly(2))
            ->method('resolve')
            ->willReturn($representation);

        $collector = new Collector($mock);

        for ($i = 5; $i; $i--) {
            $this->assertSame($representation, $collector->get('testOne'));
        }

        for ($i = 5; $i; $i--) {
            $this->assertSame($representation, $collector->get('testTwo'));
        }

        $this->assertSame($representation, $collector->get('testOne'));
    }

}