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

use RawPHP\RawConsole\Command;
use RawPHP\RawConsole\Type;

/**
 * Command class tests.
 * 
 * @category  PHP
 * @package   RawPHP/RawConsole
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class CommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Command
     */
    public $command;
    
    /**
     * Setup before each test.
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->command = new GreetCommand( );
        $this->command->configure( );
    }
    
    /**
     * Cleanup after each test.
     */
    public function tearDown()
    {
        parent::tearDown();
        
        $this->command = NULL;
    }
    
    /**
     * Test console instantiated correctly.
     */
    public function testCommandInstantiatedCorrectly( )
    {
        $this->assertNotNull( $this->command );
        
        $this->assertEquals( 'Greet Me', $this->command->name );
        $this->assertEquals( 'Greets you by whatever name you want ;)', $this->command->description );
        $this->assertEquals( '(c) 2014 RawPHP.org', $this->command->copyright );
        $this->assertEquals( 'https://github.com/rawphp/RawConsole/issues', 
                $this->command->supportSite );
        $this->assertEquals( 'https://github.com/rawphp/RawConsole', 
                $this->command->supportSource );
    }
    
    /**
     * Test command contains the default help option.
     */
    public function testCommandContainsHelpOption( )
    {
        $option = Command::getOption( $this->command, 'help' );
        
        $this->assertNotNull( $option );
        $this->assertEquals( 'h', $option->shortCode );
        $this->assertEquals( 'help', $option->longCode );
        
        $this->assertEquals( TRUE, $option->isOptional );
        $this->assertEquals( Type::BOOLEAN, $option->type );
    }
    
    /**
     * Test command contains the default verbose option.
     */
    public function testCommandContainsVerboseOption( )
    {
        $option = Command::getOption( $this->command, 'verbose' );
        
        $this->assertNotNull( $option );
        $this->assertEquals( 'v', $option->shortCode );
        $this->assertEquals( 'verbose', $option->longCode );
        
        $this->assertEquals( TRUE, $option->isOptional );
        $this->assertEquals( Type::BOOLEAN, $option->type );
    }
    
    /**
     * Test removing the first option in the command.
     */
    public function testRemoveFirstOption( )
    {
        $count = count( $this->command->options );
        
        $this->command->removeOption( $this->command->options[ 0 ]->longCode );
        
        $this->assertEquals( $count - 1, count( $this->command->options ) );
    }
    
    /**
     * Test removing the last option in the command.
     */
    public function testRemoveLastOption( )
    {
        $count = count( $this->command->options );
        
        $this->command->removeOption( $this->command->options[ $count - 1 ]->longCode );
        
        $this->assertEquals( $count - 1, count( $this->command->options ) );
    }
    
    /**
     * Test removing the second option in the command.
     */
    public function testRemoveSecondOption( )
    {
        $count = count( $this->command->options );
        
        $this->command->removeOption( $this->command->options[ 1 ]->longCode );
        
        $this->assertEquals( $count - 1, count( $this->command->options ) );
    }
    
}