<?php

/**
 * This file contains the LunrCliParserValidLongTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Shadow\Tests;

/**
 * This class contains test methods for isValidLong() in the LunrCliParser class.
 *
 * @covers Lunr\Shadow\LunrCliParser
 */
class LunrCliParserValidLongTest extends LunrCliParserTestCase
{

    /**
     * Test that isValidLong() returns FALSE for an invalid parameter.
     *
     * @param mixed $param Invalid Parameter
     *
     * @dataProvider invalidParameterProvider
     * @covers       Lunr\Shadow\LunrCliParser::isValidLong
     */
    public function testIsValidLongReturnsFalseForInvalidParameter($param): void
    {
        $method = $this->getReflectionMethod('isValidLong');

        $this->expectUserWarning('Invalid parameter given: ' . $param);

        $value = $method->invokeArgs($this->class, [ $param, 1 ]);

        $this->assertFalse($value);
    }

    /**
     * Test that isValidLong() sets error to TRUE for an invalid parameter.
     *
     * @param mixed $param Invalid Parameter
     *
     * @dataProvider invalidParameterProvider
     * @covers       Lunr\Shadow\LunrCliParser::isValidLong
     */
    public function testIsValidLongSetsErrorTrueForInvalidParameter($param): void
    {
        $method = $this->getReflectionMethod('isValidLong');

        $this->expectUserWarning('Invalid parameter given: ' . $param);

        $method->invokeArgs($this->class, [ $param, 1 ]);

        $this->assertTrue($this->getReflectionPropertyValue('error'));
    }

    /**
     * Test that isValidLong() adds a valid parameter to the ast array.
     *
     * @covers Lunr\Shadow\LunrCliParser::isValidLong
     */
    public function testIsValidLongAddsValidParameterToAst(): void
    {
        $method = $this->getReflectionMethod('isValidLong');

        $this->setReflectionPropertyValue('long', [ 'first' ]);

        $method->invokeArgs($this->class, [ 'first', 1 ]);

        $value = $this->getReflectionPropertyValue('ast');

        $this->assertArrayHasKey('first', $value);
        $this->assertEquals($value['first'], []);
    }

    /**
     * Test that isValidLong() returns FALSE for a valid parameter without arguments.
     *
     * @depends Lunr\Shadow\Tests\LunrCliParserCheckArgumentTest::testCheckArgumentReturnsFalseForValidParameterWithoutArgs
     * @covers  Lunr\Shadow\LunrCliParser::isValidLong
     */
    public function testIsValidLongReturnsFalseForValidParameterWithoutArguments(): void
    {
        $method = $this->getReflectionMethod('isValidLong');

        $this->setReflectionPropertyValue('long', [ 'first' ]);

        $value = $method->invokeArgs($this->class, [ 'first', 1 ]);

        $this->assertFalse($value);
    }

    /**
     * Test that isValidLong() returns TRUE for a valid parameter with arguments.
     *
     * @covers Lunr\Shadow\LunrCliParser::isValidLong
     */
    public function testIsValidLongReturnsTrueForValidParameterWithArguments(): void
    {
        $method = $this->getReflectionMethod('isValidLong');

        $this->setReflectionPropertyValue('args', [ 'test.php', '--second', 'arg' ]);

        $this->setReflectionPropertyValue('long', [ 'second:' ]);

        $value = $method->invokeArgs($this->class, [ 'second', 1 ]);

        $this->assertTrue($value);
    }

}

?>
