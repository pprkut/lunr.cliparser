<?php

/**
 * This file contains the LunrCliParserCheckObligatoryArgumentTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Shadow\Tests;

/**
 * This class contains test methods for checkArguments() in the LunrCliParser class.
 *
 * @covers Lunr\Shadow\LunrCliParser
 */
class LunrCliParserCheckObligatoryArgumentTest extends LunrCliParserTestCase
{

    /**
     * Test that checkArgument() returns TRUE for a valid parameter with one argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::checkArgument
     */
    public function testCheckArgumentReturnsTrueForValidParameterWithOneArg(): void
    {
        $this->setReflectionPropertyValue('args', [ 'test.php', '-b', 'arg' ]);

        $this->setReflectionPropertyValue('ast', [ 'b' => [] ]);

        $method = $this->getReflectionMethod('checkArgument');

        $value = $method->invokeArgs($this->class, [ 'b', 1, 0, 'b:' ]);

        $this->assertTrue($value);
    }

    /**
     * Test that checkArgument() returns TRUE for a valid parameter with one argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::checkArgument
     */
    public function testCheckArgumentReturnsTrueForValidParameterWithTwoArgs(): void
    {
        $this->setReflectionPropertyValue('args', [ 'test.php', '-e', 'arg1', 'arg2' ]);

        $this->setReflectionPropertyValue('ast', [ 'e' => [] ]);

        $method = $this->getReflectionMethod('checkArgument');

        $value = $method->invokeArgs($this->class, [ 'e', 1, 0, 'e::' ]);

        $this->assertTrue($value);
    }

    /**
     * Test that checkArgument() appends first argument to ast.
     *
     * @covers Lunr\Shadow\LunrCliParser::checkArgument
     */
    public function testCheckArgumentAppendsFirstArgumentToAst(): void
    {
        $this->setReflectionPropertyValue('args', [ 'test.php', '-b', 'arg' ]);

        $this->setReflectionPropertyValue('ast', [ 'b' => [] ]);

        $method = $this->getReflectionMethod('checkArgument');

        $method->invokeArgs($this->class, [ 'b', 1, 0, 'b:' ]);

        $value = $this->getReflectionPropertyValue('ast');

        $this->assertCount(1, $value['b']);
        $this->assertEquals([ 'arg' ], $value['b']);
    }

    /**
     * Test that checkArgument() appends first argument to ast.
     *
     * @covers Lunr\Shadow\LunrCliParser::checkArgument
     */
    public function testCheckArgumentAppendsSecondArgumentToAst(): void
    {
        $this->setReflectionPropertyValue('args', [ 'test.php', '-e', 'arg1', 'arg2' ]);

        $this->setReflectionPropertyValue('ast', [ 'e' => [] ]);

        $method = $this->getReflectionMethod('checkArgument');

        $method->invokeArgs($this->class, [ 'e', 1, 0, 'e::' ]);

        $value = $this->getReflectionPropertyValue('ast');

        $this->assertCount(2, $value['e']);
        $this->assertEquals([ 'arg1', 'arg2' ], $value['e']);
    }

    /**
     * Test that checkArgument() returns FALSE when the argument is missing.
     *
     * @covers Lunr\Shadow\LunrCliParser::checkArgument
     */
    public function testCheckArgumentReturnsFalseForArgumentMissing(): void
    {
        $this->setReflectionPropertyValue('args', [ 'test.php', '-b' ]);

        $this->setReflectionPropertyValue('ast', [ 'b' => [] ]);

        $method = $this->getReflectionMethod('checkArgument');

        $this->expectUserWarning('Missing argument for -b');

        $value = $method->invokeArgs($this->class, [ 'b', 1, 0, 'b:' ]);

        $this->assertFalse($value);
    }

    /**
     * Test that checkArgument() returns FALSE when the argument is missing.
     *
     * @covers Lunr\Shadow\LunrCliParser::checkArgument
     */
    public function testCheckArgumentReturnsFalseForArgumentMissingWithAnotherParameterAfter(): void
    {
        $this->setReflectionPropertyValue('args', [ 'test.php', '-b', '-c' ]);

        $this->setReflectionPropertyValue('ast', [ 'b' => [] ]);

        $method = $this->getReflectionMethod('checkArgument');

        $this->expectUserWarning('Missing argument for -b');

        $value = $method->invokeArgs($this->class, [ 'b', 1, 0, 'b:' ]);

        $this->assertFalse($value);
    }

}

?>
