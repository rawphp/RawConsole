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
 * @package   RawPHP/RawConsole/Writers
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawConsole\Writers\Tests;

use RawPHP\RawConsole\StandardHelpWriter;
use RawPHP\RawConsole\Command;
use RawPHP\RawConsole\Tests\GreetCommand;
use PHPUnit_Framework_TestCase;

/**
 * Base class for commands used on the command-line.
 * 
 * @category  PHP
 * @package   RawPHP/RawConsole/Writers
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class StandardHelpWriterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var StandardHelpWriter
     */
    public $writer          = NULL;
    /**
     * @var Command
     */
    private $_command       = NULL;
    
    private $_helpText      = '';
    
    /**
     * Setup before each test.
     */
    public function setUp()
    {
        parent::setUp();
        
        $this->writer = new StandardHelpWriter( );
        $this->_command = new GreetCommand( );
        $this->_command->configure( );
    }
    
    /**
     * Cleanup after each test.
     */
    public function tearDown()
    {
        parent::tearDown();
        
        $this->writer    = NULL;
        $this->_command  = NULL;
        $this->_helpText = NULL;
    }
    
    /**
     * Test writer instantiates correctly.
     */
    public function testWriterInstantiatedCorrectly( )
    {
        $this->assertNotNull( $this->writer );
    }
    
    /**
     * Test writer.
     */
    public function testWriter( )
    {
        $this->writer->addFilter( StandardHelpWriter::ON_WRITE_HELP_FILTER, array( $this, 'setHelpText' ) );
        
        $this->writer->write( $this->_command );
        
        $this->assertContains( 'Usage: ./greet --help', $this->_helpText );
    }
    
    /**
     * Helper method to get the command help text output from the filter.
     * 
     * @param string $helpText the help text
     * 
     * @return string the help text
     */
    public function setHelpText( $helpText )
    {
        $this->_helpText = $helpText;
        
        return $helpText;
    }
}