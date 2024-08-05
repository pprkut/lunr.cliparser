<?php

/**
 * This file contains the LunrCliParserBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Shadow\Tests;

/**
 * This class contains base test methods for the LunrCliParser class.
 *
 * @covers Lunr\Shadow\LunrCliParser
 */
class LunrCliParserBaseTest extends LunrCliParserTest
{

    /**
     * Test that the short options string is passed correctly.
     */
    public function testShortOptsIsPassedCorrectly(): void
    {
        $this->assertPropertyEquals('short', 'ab:c;d:;e::');
    }

    /**
     * Test that the long options string is passed correctly.
     */
    public function testLongOptsIsPassedCorrectly(): void
    {
        $this->assertPropertyEquals('long', [ 'first', 'second:', 'third;', 'fourth:;', 'fifth::' ]);
    }

    /**
     * Test that the argument array is empty by default.
     */
    public function testArgsIsEmptyArrayByDefault(): void
    {
        $value = $this->get_reflection_property_value('args');

        $this->assertArrayEmpty($value);
    }

    /**
     * Test that the checked array is empty by default.
     */
    public function testCheckedIsEmptyArrayByDefault(): void
    {
        $value = $this->get_reflection_property_value('checked');

        $this->assertArrayEmpty($value);
    }

    /**
     * Test that the AST array is empty by default.
     */
    public function testASTisEmptyArrayByDefault(): void
    {
        $value = $this->get_reflection_property_value('ast');

        $this->assertArrayEmpty($value);
    }

    /**
     * Test that error is set to FALSE by default.
     */
    public function testErrorIsFalseByDefault(): void
    {
        $this->assertFalse($this->get_reflection_property_value('error'));
    }

    /**
     * Test that is_invalid_commandline() returns the value of error.
     *
     * @covers Lunr\Shadow\LunrCliParser::is_invalid_commandline
     */
    public function testIsInvalidCommandLineReturnsError(): void
    {
        $value = $this->get_reflection_property_value('error');

        $this->assertEquals($value, $this->class->is_invalid_commandline());
    }

}

?>
