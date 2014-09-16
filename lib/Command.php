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
    public $version             = NULL;
    /**
     * @var string
     */
    public $description         = NULL;
    /**
     * @var string
     */
    public $copyright           = NULL;
    /**
     * @var string
     */
    public $supportEmail        = NULL;
    /**
     * @var string
     */
    public $supportSite         = NULL;
    /**
     * @var string
     */
    public $supportForum        = NULL;
    /**
     * @var string
     */
    public $supportSource       = NULL;
    /**
     * @var array
     */
    public $options             = array( );
    
    /**
     * Constructs a new command instance.
     */
    public function __construct( )
    {
        $this->init( );
    }
    
    /**
     * This method adds the help and verbose options to the command.
     * 
     * NOTE: Do not call this method from subclasses. It is already called
     * by the constructor.
     * 
     * You can optionally remove these options by clearing the command
     * options array before adding your own commands.
     */
    public function init( )
    {
        $option = new Option( );
        $option->shortCode   = 'h';
        $option->longCode    = 'help';
        $option->isOptional  = TRUE;
        $option->type        = Type::BOOLEAN;
        $option->shortDescription = 'Show the help menu';
        
        $this->options[] = $option;
        
        $option = new Option( );
        $option->shortCode   = 'v';
        $option->longCode    = 'verbose';
        $option->isOptional  = TRUE;
        $option->type        = Type::BOOLEAN;
        $option->shortDescription = 'Show detailed log';
        
        $this->options[] = $option;
        
        $this->doAction( self::ON_COMMAND_INIT_ACTION );
    }
    
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
     * Removes an option by its long code.
     * 
     * @param string $longCode option long code
     * 
     * @return bool TRUE on success, FALSE on failure
     */
    public function removeOption( $longCode )
    {
        $retVal = FALSE;
        
        $i = 0;
        
        foreach( $this->options as $option )
        {
            if ( $longCode === $option->longCode )
            {
                break;
            }
            
            $i++;
        }
        
        if ( $i !== count( $this->options ) )
        {
            unset( $this->options[ $i ] );
            
            $retVal = TRUE;
        }
        
        $this->doAction( self::ON_REMOVE_OPTION_ACTION );
        
        return $this->filter( self::ON_REMOVE_OPTION_FILTER, $retVal, $longCode );
    }
    
    /**
     * Gets an option either by short or long code.
     * 
     * @param Command $command  the command
     * @param string  $longCode the command name (code)
     * 
     * @return Option the option
     * 
     * @throws CommandException if option is not found
     */
    public static function getOption( Command $command, $longCode )
    {
        foreach( $command->options as $op )
        {
            if ( '--' === substr( $longCode, 0, 2 ) )
            {
                $longCode = substr( $longCode, 2 );
            }
            elseif ( '-' === substr( $longCode, 0, 1 ) )
            {
                $longCode = substr( $longCode, 1 );
            }
            
            if ( $op->shortCode === $longCode || $op->longCode === $longCode )
            {
                return $op;
            }
        }
        
        throw new CommandException( 'Unable to find option: ' . $longCode );
    }
    
    /**
     * Prints the help menu for the command.
     * 
     * @todo implement this
     */
    public function help()
    {
        
    }
    
    const ON_COMMAND_INIT_ACTION    = 'on_command_init_action';
    const ON_ADD_OPTION_ACTION      = 'on_add_option_action';
    const ON_REMOVE_OPTION_ACTION   = 'on_remove_option_action';
    
    const ON_ADD_OPTION_FILTER      = 'on_add_option_filter';
    const ON_REMOVE_OPTION_FILTER   = 'on_remove_option_filter';
}
