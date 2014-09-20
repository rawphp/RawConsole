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

use RawPHP\RawConsole\Console;

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
class ConsoleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Console
     */
    public $console;
    
    /**
     * Setup before each test.
     */
    public function setUp()
    {
        global $config;
        
        parent::setUp();
        
        $this->console = new Console( );
        $this->console->init( $config );
    }
    
    /**
     * Cleanup after each test.
     */
    public function tearDown()
    {
        parent::tearDown();
        
        $this->console = NULL;
    }
    
    /**
     * Test console instantiated correctly.
     */
    public function testConsoleInstantiatedCorrectly( )
    {
        $this->assertNotNull( $this->console );
    }
    
    /**
     * Test getting invalid command.
     */
    public function testGetInvalidCommandByName( )
    {
        $args = array( 'program', 'fake' );
        
        $command = $this->console->getCommand( $args );
        
        $this->assertNull( $command );
    }
    
    /**
     * Test running command from array namespaces.
     */
    public function testRunCommandsInArrayNamespaces( )
    {
        $args = array( 'program', 'ForeignNSOne', '--name', 'John', '--yell' );
        
        $this->console->run( $args );
        
        $this->expectOutputString( 'HELLO, JOHN' . PHP_EOL );
    }
    
    /**
     * Test run command with extra options.
     */
    public function testRunCommandWithExtraOptions( )
    {
        $args = array( 'program', 'GreetFull', '--name', 'John', '--yell', '-l', 'Smith' );
        
        $this->console->run( $args );
        
        $this->expectOutputString( 'HELLO, JOHN SMITH' . PHP_EOL );
    }
}