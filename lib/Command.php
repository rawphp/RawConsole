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

namespace RawPHP\RawConsole;

use RawPHP\RawBase\Component;

/**
 * Base class for commands used on the command-line.
 * 
 * @category  PHP
 * @package   RawPHP/RawConsole
 * @author    Tom Kaczohca <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
abstract class Command extends Component implements ICommand
{
    /**
     * @var string
     */
    public $name                = NULL;
    /**
     * @var string
     */
    public $description         = NULL;
    /**
     * @var array
     */
    public $options             = array( );
    
    /**
     * Configures the command.
     */
    public abstract function configure( );
    
    /**
     * Executes the command action.
     */
    public abstract function execute( );
    
    /**
     * Add an option to the command.
     * 
     * @param Option $option the option
     * 
     * @filter ON_ADD_OPTION_FILTER(1)
     * 
     * @action ON_ADD_OPTION_ACTION
     * 
     * @return Command the command
     */
    public function addOption( Option $option )
    {
        $this->options[] = $this->filter( self::ON_ADD_OPTION_FILTER, $option );
        
        $this->doAction( self::ON_ADD_OPTION_ACTION );
        
        return $this;
    }
    
    /**
     * Gets an option either by short or long code.
     * 
     * @param Command $command the command
     * @param string  $name    the command name (code)
     * 
     * @return Option the option
     * 
     * @throws CommandException if option is not found
     */
    public static function getOption( Command $command, $name )
    {
        foreach( $command->options as $op )
        {
            if ( '--' === substr( $name, 0, 2 ) )
            {
                $name = substr( $name, 2 );
            }
            elseif ( '-' === substr( $name, 0, 1 ) )
            {
                $name = substr( $name, 1 );
            }
            
            if ( $op->shortCode === $name || $op->longCode === $name )
            {
                return $op;
            }
        }
        
        throw new CommandException( 'Unable to find option: ' . $name );
    }
    
    /**
     * Prints the help menu for the command.
     * 
     * @todo implement this
     */
    public function help()
    {
        
    }
    
    const ON_ADD_OPTION_ACTION = 'on_add_option_action';
    const ON_ADD_OPTION_FILTER = 'on_add_option_filter';
}
