<?php

namespace uSIreF\AutoWire\Unit\Tests;

use uSIreF\AutoWire\Unit\Abstracts\TestCase;
use uSIreF\AutoWire\{CycleHelper, Exception};

/**
 * This file defines test class for CycleHelper.
 *
 * @author Martin Kovar <mkovar86@gmail.com>
 */
class CycleHelperTest extends TestCase {

    /**
     * Success test for method start.
     *
     * @return void
     */
    public function testStart() {
        $helper = new CycleHelper();

        $this->assertInstanceOf(CycleHelper::class, $helper->start('test_1'));
        $this->assertInstanceOf(CycleHelper::class, $helper->start('test_2'));

        $this->expectException(Exception::class);
        $helper->start('test_1');
    }

    /**
     * Success test for method commit.
     *
     * @return void
     */
    public function testCommit() {
        $helper = new CycleHelper();

        $this->assertInstanceOf(CycleHelper::class, $helper->start('test_1'));
        $this->assertInstanceOf(CycleHelper::class, $helper->commit('test_1'));

        $this->expectException(Exception::class);
        $helper->commit('test_1');
    }

}