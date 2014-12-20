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
 * @package   RawPHP\RawConsole
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawConsole;

use RawPHP\RawConsole\Exception\CommandException;
use RawPHP\RawSupport\Util;

/**
 * Base class for commands used on the command-line.
 * 
 * @category  PHP
 * @package   RawPHP\RawConsole
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class Option
{
    /**
     * @var string
     */
    public $shortCode           = NULL;
    /**
     * @var string
     */
    public $longCode            = NULL;
    /**
     * @var string
     */
    public $shortDescription    = NULL;
    /**
     * @var string
     */
    public $longDescription     = NULL;
    /**
     * @var string
     */
    public $value               = NULL;
    /**
     * @var string
     */
    public $type                = Type::STRING;
    /**
     * @var bool
     */
    public $isRequired          = FALSE;
    /**
     * @var bool
     */
    public $isOptional          = FALSE;
    
    /**
     * Checks if the argument is a short code.
     * 
     * @param string $arg the argument
     * 
     * @return bool TRUE if short code, else FALSE
     */
    public static function isShortCode( $arg )
    {
        return ( strlen( $arg ) === 2 ) && ( $arg[ 0 ] === '-' && $arg[ 1 ] !== '-' );
    }
    
    /**
     * Checks if the argument is a long code.
     * 
     * @param string $arg the argument
     * 
     * @return bool TRUE if long code, else FALSE
     * 
     * @throws CommandException if the argument is malformed
     */
    public static function isLongCode( $arg )
    {
        $retVal = ( strlen( $arg ) > 2 ) && ( '-' === $arg[ 0 ] && '-' === $arg[ 1 ] );
        
        if ( 2 === strlen( $arg ) )
        {
            return $retVal;
        }
        
        if ( ( !is_bool( $arg ) && !Util::validIndex( 2, $arg ) ) || '-' === $arg[ 2 ] )
        {
            throw new CommandException( 'Unknown option type [ ' . $arg . ' ]' );
        }
        
        return $retVal;
    }
    
    /**
     * Sets the required argument.
     * 
     * @param Option $option the option to set to
     * @param mixed  $arg    the argument
     * 
     * @throws CommandException if argument is missing
     */
    public static function setRequiredValue( Option &$option, $arg )
    {
        if ( self::isShortCode( $arg ) || self::isLongCode( $arg ) )
        {
            throw new CommandException( 'Missing argument for option --' . $option->longCode );
        }
        else
        {
            if ( is_string( $arg ) )
            {
                $arg = trim( $arg );
            }
            
            $option->value = $arg;
        }
    }
    
    /**
     * Sets an optional argument if available.
     * 
     * @param Option $option the option to set to
     * @param mixed  $arg    the argument
     */
    public static function setOptionalValue( Option &$option, $arg )
    {
        if ( !self::isShortCode( $arg ) && !self::isLongCode( $arg ) )
        {
            if ( is_bool( $arg ) )
            {
                $option->value = ( bool )$arg;
            }
            elseif ( is_string( $arg ) )
            {
                $arg = trim( $arg );
            
                $option->value = $arg;
            }
        }
    }
}