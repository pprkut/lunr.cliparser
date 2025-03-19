<?php

/**
 * This file contains the LunrCliParserValidShortTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Shadow\Tests;

/**
 * This class contains test methods for isValidShort() in the LunrCliParser class.
 *
 * @covers Lunr\Shadow\LunrCliParser
 */
class LunrCliParserValidShortTest extends LunrCliParserTestCase
{

    /**
     * Test that isValidShort() returns FALSE for an invalid parameter.
     *
     * @param mixed $param Invalid Parameter
     *
     * @dataProvider invalidParameterProvider
     * @covers       Lunr\Shadow\LunrCliParser::isValidShort
     */
    public function testIsValidShortReturnsFalseForInvalidParameter($param): void
    {
        $method = $this->getReflectionMethod('isValidShort');

        $this->expectUserWarning('Invalid parameter given: ' . $param);

        $value = $method->invokeArgs($this->class, [ $param, 1 ]);

        $this->assertFalse($value);
    }

    /**
     * Test that isValidShort() sets error to TRUE for an invalid parameter.
     *
     * @param mixed $param Invalid Parameter
     *
     * @dataProvider invalidParameterProvider
     * @covers       Lunr\Shadow\LunrCliParser::isValidShort
     */
    public function testIsValidShortSetsErrorTrueForInvalidParameter($param): void
    {
        $method = $this->getReflectionMethod('isValidShort');

        $this->expectUserWarning('Invalid parameter given: ' . $param);

        $method->invokeArgs($this->class, [ $param, 1 ]);

        $this->assertTrue($this->getReflectionPropertyValue('error'));
    }

    /**
     * Test that isValidShort() adds a valid parameter to the ast array.
     *
     * @covers Lunr\Shadow\LunrCliParser::isValidShort
     */
    public function testIsValidShortAddsValidParameterToAst(): void
    {
        $method = $this->getReflectionMethod('isValidShort');

        $this->setReflectionPropertyValue('short', 'a');

        $method->invokeArgs($this->class, [ 'a', 1 ]);

        $value = $this->getReflectionPropertyValue('ast');

        $this->assertArrayHasKey('a', $value);
        $this->assertEquals($value['a'], []);
    }

    /**
     * Test that isValidShort() returns FALSE for a valid parameter without arguments.
     *
     * @depends Lunr\Shadow\Tests\LunrCliParserCheckArgumentTest::testCheckArgumentReturnsFalseForValidParameterWithoutArgs
     * @covers  Lunr\Shadow\LunrCliParser::isValidShort
     */
    public function testIsValidShortReturnsFalseForValidParameterWithoutArguments(): void
    {
        $method = $this->getReflectionMethod('isValidShort');

        $this->setReflectionPropertyValue('short', 'a');

        $value = $method->invokeArgs($this->class, [ 'a', 1 ]);

        $this->assertFalse($value);
    }

    /**
     * Test that isValidShort() returns TRUE for a valid parameter with arguments.
     *
     * @covers Lunr\Shadow\LunrCliParser::isValidShort
     */
    public function testIsValidShortReturnsTrueForValidParameterWithArguments(): void
    {
        $method = $this->getReflectionMethod('isValidShort');

        $this->setReflectionPropertyValue('args', [ 'test.php', '-b', 'arg' ]);

        $this->setReflectionPropertyValue('short', 'b:');

        $value = $method->invokeArgs($this->class, [ 'b', 1 ]);

        $this->assertTrue($value);
    }

}

?>
