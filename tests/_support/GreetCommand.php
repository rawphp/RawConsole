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
use RawPHP\RawConsole\Option;
use RawPHP\RawConsole\Type;

/**
 * The Greet class with just name and yell option.
 * 
 * @category  PHP
 * @package   RawPHP/RawConsole
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class GreetCommand extends Command
{
    /**
     * Configures the command.
     */
    public function configure( )
    {
        $option = new Option( );
        $option->shortCode   = 'n';
        $option->longCode    = 'name';
        $option->type        = Type::STRING;
        $option->isRequired  = TRUE;
        $option->description = 'Name of person you want to greet';
        
        $this->addOption( $option );
        
        $option = new Option( );
        $option->shortCode   = 'y';
        $option->longCode    = 'yell';
        $option->type        = Type::BOOLEAN;
        $option->isOptional  = TRUE;
        $option->description = 'The greeting will be printed in uppercase letters';
        
        $this->addOption( $option );
    }
    
    /**
     * Executes the command action.
     */
    public function execute( )
    {
        $name = self::getOption( $this, 'name' )->value;
        $yell = ( bool )self::getOption( $this, 'yell' )->value;
        
        $message = 'Hello, ' . $name . PHP_EOL;
        
        if ( $yell )
        {
            $message = strtoupper( $message );
        }
        
        echo $message;
    }

}