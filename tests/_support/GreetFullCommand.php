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
 * PHP version 5.3
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
use RawPHP\RawConsole\Type;

/**
 * Greet Command that adds last name option to the command.
 * 
 * @category  PHP
 * @package   RawPHP/RawConsole
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class GreetFullCommand extends GreetCommand
{
    /**
     * Configures the command.
     */
    public function configure()
    {
        parent::configure();
        
        $option = new Option( );
        $option->shortCode   = 'l';
        $option->longCode    = 'last';
        $option->type        = Type::STRING;
        $option->isOptional  = TRUE;
        $option->shortDescription = 'If included, then it will greet by full name';
        
        $this->options[] = $option;
    }
    
    /**
     * Executes the command action.
     */
    public function execute()
    {
        $name = self::getOption( $this, 'name' )->value;
        $last = self::getOption( $this, 'last' )->value;
        $yell = ( bool )self::getOption( $this, 'yell' )->value;
        
        $message = 'Hello, ' . $name;
        
        if ( !empty( $last ) )
        {
            $message .= ' ' . $last;
        }
        
        $message .= PHP_EOL;
        
        if ( $yell )
        {
            $message = strtoupper( $message );
        }
        
        echo $message;
    }
}