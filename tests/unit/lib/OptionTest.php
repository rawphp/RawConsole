<?php

/**
 * This file is part of RawPHP - a PHP Framework.
 * 
 * Copyright (c) 2014 RawPHP.org
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 * 
 * PHP version 5.4
 * 
 * @category  PHP
 * @package   RawPHP/RawConsole
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawConsole\Tests;

use RawPHP\RawConsole\Option;

/**
 * Option class tests.
 * 
 * @category  PHP
 * @package   RawPHP/RawConsole
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class OptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Option
     */
    protected $option;
    
    /**
     * Setup before each test.
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->option = new Option( );
    }
    
    /**
     * Cleanup after each test.
     */
    public function tearDown()
    {
        parent::tearDown();
        
        $this->option = NULL;
    }
    
    /**
     * Test option instantiated correctly.
     */
    public function testOptionInstantiatedCorrectly( )
    {
        $this->assertNotNull( $this->option );
    }
    
    /**
     * Tests that is short code works correctly.
     */
    public function testIsShortCodeWorksCorrectly( )
    {
        $this->assertTrue ( Option::isShortCode( '-a' ) );
        $this->assertFalse( Option::isShortCode( '--' ) );
        $this->assertFalse( Option::isShortCode( '--a' ) );
    }
    
    /**
     * Tests that is long code works correctly. 
     */
    public function testIsLongCodeWorksCorrectly( )
    {
        $this->assertTrue ( Option::isLongCode( '--a' ) );
        $this->assertFalse( Option::isLongCode( '-a' ) );
    }
    
    /**
     * Test exception is thrown for invalid long argument.
     * 
     * @expectedException RawPHP\RawConsole\CommandException
     */
    public function testExceptionisThrownForInvalidArg( )
    {
        Option::isLongCode( '---' );
    }
}
