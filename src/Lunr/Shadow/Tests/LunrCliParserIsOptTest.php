<?php

/**
 * This file contains the LunrCliParserIsOptTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Shadow\Tests;

/**
 * This class contains test methods for isOpt() in the LunrCliParser class.
 *
 * @covers Lunr\Shadow\LunrCliParser
 */
class LunrCliParserIsOptTest extends LunrCliParserTestCase
{

    /**
     * Test that isOpt() pushes the initial argument into the checked array.
     *
     * @covers Lunr\Shadow\LunrCliParser::isOpt
     */
    public function testIsOptPushesInitialArgumentIntoChecked(): void
    {
        $method = $this->getReflectionMethod('isOpt');

        $method->invokeArgs($this->class, [ '1', 2 ]);

        $this->assertPropertyEquals('checked', [ '1' ]);
    }

    /**
     * Test that isOpt() pushes non-initial arguments at the end of the checked array.
     *
     * @covers Lunr\Shadow\LunrCliParser::isOpt
     */
    public function testIsOptPushesNonInitialArgumentAtTheEndOfChecked(): void
    {
        $method = $this->getReflectionMethod('isOpt');

        $method->invokeArgs($this->class, [ '1', 2 ]);
        $method->invokeArgs($this->class, [ '2', 2 ]);

        $this->assertPropertyEquals('checked', [ '1', '2' ]);
    }

    /**
     * Test that isOpt() returns FALSE for an invalid parameter.
     *
     * @param mixed $param Invalid Parameter
     *
     * @dataProvider invalidParameterProvider
     * @depends      Lunr\Shadow\Tests\LunrCliParserValidShortTest::testIsValidShortReturnsFalseForInvalidParameter
     * @covers       Lunr\Shadow\LunrCliParser::isOpt
     */
    public function testIsOptReturnsFalseForInvalidParameter($param): void
    {
        $method = $this->getReflectionMethod('isOpt');

        $this->expectUserWarning('Invalid parameter given: ' . $param);

        $value = $method->invokeArgs($this->class, [ $param, 1 ]);

        $this->assertFalse($value);
    }

    /**
     * Test that isOpt() sets error to TRUE for an invalid parameter.
     *
     * @param mixed $param Invalid Parameter
     *
     * @dataProvider invalidParameterProvider
     * @depends      Lunr\Shadow\Tests\LunrCliParserValidShortTest::testIsValidShortSetsErrorTrueForInvalidParameter
     * @covers       Lunr\Shadow\LunrCliParser::isOpt
     */
    public function testIsOptSetsErrorTrueForInvalidParameter($param): void
    {
        $method = $this->getReflectionMethod('isOpt');

        $this->expectUserWarning('Invalid parameter given: ' . $param);

        $method->invokeArgs($this->class, [ $param, 1 ]);

        $this->assertTrue($this->getReflectionPropertyValue('error'));
    }

    /**
     * Test isOpt() with a superfluous toplevel argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::isOpt
     */
    public function testIsOptWithSuperfluousToplevelArgument(): void
    {
        $method = $this->getReflectionMethod('isOpt');

        $this->expectUserNotice('Superfluous argument: first');

        $value = $method->invokeArgs($this->class, [ 'first', 1, TRUE ]);

        $this->assertFalse($value);
    }

    /**
     * Test that isOpt() returns FALSE for a valid short parameter without arguments.
     *
     * @depends Lunr\Shadow\Tests\LunrCliParserValidShortTest::testIsValidShortReturnsFalseForValidParameterWithoutArguments
     * @covers  Lunr\Shadow\LunrCliParser::isOpt
     */
    public function testIsOptReturnsFalseForValidShortParameterWithoutArguments(): void
    {
        $method = $this->getReflectionMethod('isOpt');

        $value = $method->invokeArgs($this->class, [ '-a', 1 ]);

        $this->assertFalse($value);
    }

    /**
     * Test that isOpt() returns FALSE for a valid long parameter without arguments.
     *
     * @depends Lunr\Shadow\Tests\LunrCliParserValidLongTest::testIsValidLongReturnsFalseForValidParameterWithoutArguments
     * @covers  Lunr\Shadow\LunrCliParser::isOpt
     */
    public function testIsOptReturnsFalseForValidLongParameterWithoutArguments(): void
    {
        $method = $this->getReflectionMethod('isOpt');

        $value = $method->invokeArgs($this->class, [ '--first', 1 ]);

        $this->assertFalse($value);
    }

    /**
     * Test that isOpt() returns TRUE for a valid short parameter without arguments.
     *
     * @depends Lunr\Shadow\Tests\LunrCliParserValidShortTest::testIsValidShortReturnsTrueForValidParameterWithArguments
     * @covers  Lunr\Shadow\LunrCliParser::isOpt
     */
    public function testIsOptReturnsTrueForValidShortParameterWithArguments(): void
    {
        $this->setReflectionPropertyValue('args', [ 'test.php', '-b', 'arg' ]);

        $method = $this->getReflectionMethod('isOpt');

        $value = $method->invokeArgs($this->class, [ '-b', 1 ]);

        $this->assertTrue($value);
    }

    /**
     * Test that isOpt() returns TRUE for a valid long parameter with arguments.
     *
     * @depends Lunr\Shadow\Tests\LunrCliParserValidLongTest::testIsValidLongReturnsTrueForValidParameterWithArguments
     * @covers  Lunr\Shadow\LunrCliParser::isOpt
     */
    public function testIsOptReturnsTrueForValidLongParameterWithArguments(): void
    {
        $this->setReflectionPropertyValue('args', [ 'test.php', '--second', 'arg' ]);

        $method = $this->getReflectionMethod('isOpt');

        $value = $method->invokeArgs($this->class, [ '--second', 1 ]);

        $this->assertTrue($value);
    }

    /**
     * Test that isOpt() returns FALSE if the parameter given is an argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::isOpt
     */
    public function testIsOptReturnsFalseForArgument(): void
    {
        $method = $this->getReflectionMethod('isOpt');

        $value = $method->invokeArgs($this->class, [ 'arg', 2 ]);

        $this->assertFalse($value);
    }

}

?>
