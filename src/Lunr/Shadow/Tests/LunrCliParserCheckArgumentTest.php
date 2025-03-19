<?php

/**
 * This file contains the LunrCliParserCheckArgumentTest class.
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
class LunrCliParserCheckArgumentTest extends LunrCliParserTestCase
{

    /**
     * Test that checkArgument() returns FALSE for a valid parameter without arguments.
     *
     * @covers Lunr\Shadow\LunrCliParser::checkArgument
     */
    public function testCheckArgumentReturnsFalseForValidParameterWithoutArgs(): void
    {
        $method = $this->getReflectionMethod('checkArgument');

        $value = $method->invokeArgs($this->class, [ 'a', 1, 0, 'a' ]);

        $this->assertFalse($value);
    }

    /**
     * Test that checkArgument() returns TRUE for a superfluous argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::checkArgument
     */
    public function testCheckArgumentReturnsTrueForSuperfluousArgument(): void
    {
        $this->setReflectionPropertyValue('args', [ 'test.php', '-a', 'arg' ]);

        $method = $this->getReflectionMethod('checkArgument');

        $this->expectUserNotice('Superfluous argument: arg');

        $value = $method->invokeArgs($this->class, [ 'a', 1, 0, 'a' ]);

        $this->assertTrue($value);
    }

}

?>
