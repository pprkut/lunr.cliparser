<?php

/**
 * This file contains the LunrCliParserCheckOptionalArgumentTest class.
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
class LunrCliParserCheckOptionalArgumentTest extends LunrCliParserTestCase
{

    /**
     * Test that checkArgument() returns TRUE for a valid parameter with one argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::checkArgument
     */
    public function testCheckArgumentReturnsTrueForValidParameterWithOneArg(): void
    {
        $this->setReflectionPropertyValue('args', [ 'test.php', '-c', 'arg' ]);

        $this->setReflectionPropertyValue('ast', [ 'c' => [] ]);

        $method = $this->getReflectionMethod('checkArgument');

        $value = $method->invokeArgs($this->class, [ 'c', 1, 0, 'c;' ]);

        $this->assertTrue($value);
    }

    /**
     * Test that checkArgument() returns TRUE for a valid parameter with one argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::checkArgument
     */
    public function testCheckArgumentReturnsTrueForValidParameterWithTwoArgs(): void
    {
        $this->setReflectionPropertyValue('args', [ 'test.php', '-f', 'arg1', 'arg2' ]);

        $this->setReflectionPropertyValue('ast', [ 'f' => [] ]);

        $method = $this->getReflectionMethod('checkArgument');

        $value = $method->invokeArgs($this->class, [ 'f', 1, 0, 'f;;' ]);

        $this->assertTrue($value);
    }

    /**
     * Test that checkArgument() appends first argument to ast.
     *
     * @covers Lunr\Shadow\LunrCliParser::checkArgument
     */
    public function testCheckArgumentAppendsFirstArgumentToAst(): void
    {
        $this->setReflectionPropertyValue('args', [ 'test.php', '-c', 'arg' ]);

        $this->setReflectionPropertyValue('ast', [ 'c' => [] ]);

        $method = $this->getReflectionMethod('checkArgument');

        $method->invokeArgs($this->class, [ 'c', 1, 0, 'c;' ]);

        $value = $this->getReflectionPropertyValue('ast');

        $this->assertCount(1, $value['c']);
        $this->assertEquals([ 'arg' ], $value['c']);
    }

    /**
     * Test that checkArgument() appends first argument to ast.
     *
     * @covers Lunr\Shadow\LunrCliParser::checkArgument
     */
    public function testCheckArgumentAppendsSecondArgumentToAst(): void
    {
        $this->setReflectionPropertyValue('args', [ 'test.php', '-f', 'arg1', 'arg2' ]);

        $this->setReflectionPropertyValue('ast', [ 'f' => [] ]);

        $method = $this->getReflectionMethod('checkArgument');

        $method->invokeArgs($this->class, [ 'f', 1, 0, 'f;;' ]);

        $value = $this->getReflectionPropertyValue('ast');

        $this->assertCount(2, $value['f']);
        $this->assertEquals([ 'arg1', 'arg2' ], $value['f']);
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

        $value = $method->invokeArgs($this->class, [ 'b', 1, 0, 'b;' ]);

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

        $value = $method->invokeArgs($this->class, [ 'b', 1, 0, 'b;' ]);

        $this->assertFalse($value);
    }

}

?>
