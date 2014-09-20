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
 * The Console class.
 * 
 * @category  PHP
 * @package   RawPHP/RawConsole
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class Console extends Component implements IConsole
{
    /**
     * @var ICommand
     */
    public $command         = NULL;
    /**
     * @var array
     */
    public $arguments       = array( );
    /**
     * @var array
     */
    public $namespaces      = array( );
    
    /**
     * Initialises the console.
     * 
     * @param array $config configuration array
     */
    public function init( $config = NULL )
    {
        parent::init( $config );
        
        if ( isset( $config[ 'command_namespaces' ] ) )
        {
            $this->namespaces = $config[ 'command_namespaces' ];
        }
    }
    
    /**
     * Runs the requested command.
     * 
     * @param array $args command line arguments
     * 
     * @action ON_BEFORE_RUN_ACTION
     * $action ON_AFTER_RUN_ACTION
     * 
     * @throws CommandException in exceptional circustances
     */
    public function run( $args )
    {
        $this->doAction( self::ON_BEFORE_RUN_ACTION );
        
        try
        {
            $this->command = $this->getCommand( $args );

            if ( NULL == $this->command )
            {
                throw new CommandException( 'Command: ' . $args[ 1 ] . ' not found' );
            }

            $this->processArgs( $this->command, $args );

            $this->command->execute( );
        }
        catch ( CommandException $e )
        {
            echo 'Error: ' . $e->getMessage( ) . PHP_EOL;
        }
        catch ( \Exception $e )
        {
            echo 'Unknown error occurred' . PHP_EOL;
        }
        
        $this->doAction( self::ON_AFTER_RUN_ACTION );
    }
    
    /**
     * Get the requested command.
     * 
     * @param array $args command line arguments
     * 
     * @global array $commandNamespaces command namespaces
     * 
     * @action ON_BEFORE_GET_COMMAND_ACTION
     * @action ON_AFTER_GET_COMMAND_ACTION
     * 
     * @filter ON_GET_COMMAND_FILTER(2)
     * 
     * @return ICommand the command
     */
    public function getCommand( $args )
    {
        //global $commandNamespaces;
        
        $this->doAction( self::ON_BEFORE_GET_COMMAND_ACTION );
        
        $class = strtoupper( substr( $args[ 1 ], 0, 1 ) ) . substr( $args[ 1 ], 1 );
        $class .= 'Command';
        
        $command = NULL;
        
        if ( class_exists( $class ) )
        {
            $command = new $class( );
        }
        
        if ( NULL === $command && !empty( $this->namespaces ) )
        {
            foreach( $this->namespaces as $ns )
            {
                $name = $ns . $class;
                
                if ( class_exists( $name ) )
                {
                    $command = new $name( );
                    
                    break;
                }
            }
        }
        
        if ( NULL !== $command )
        {
            $command->configure( );
        }
        
        $this->doAction( self::ON_AFTER_GET_COMMAND_ACTION );
        
        return $this->filter( self::ON_GET_COMMAND_FILTER, $command, $args );
    }
    
    /**
     * Processes the command line arguments and sets the option
     * values for the command.
     * 
     * @param ICommand $command the command reference
     * @param array    $args    command line args
     * 
     * @action ON_BEFORE_PROCESS_ARGS_ACTION
     * @action ON_AFTER_PROCESS_ARGS_ACTION
     * 
     * @throws CommandException
     */
    public function processArgs( ICommand &$command, $args )
    {
        $this->doAction( self::ON_BEFORE_PROCESS_ARGS_ACTION );
        
        $i = 0;
        
        $ops = array_slice( $args, 2 );
        
        while ( $i < count( $ops ) )
        {
            $o = $ops[ $i ];
            
            if ( Option::isShortCode( $o ) || Option::isLongCode( $o ) )
            {
                $option = Command::getOption( $command, $o );
                
                if ( $option->isRequired )
                {
                    $i++;

                    if ( !self::validIndex( $i, $ops ) )
                    {
                        throw new CommandException( 'Missing argument for option: ' . $o );
                    }
                    
                    Option::setRequiredValue( $option, $ops[ $i ] );
                }
                
                if ( $option->isOptional )
                {
                    $value = NULL;
                    
                    if ( $option->type === Type::BOOLEAN )
                    {
                        $value = TRUE;
                    }
                    else
                    {
                        $i++;
                        
                        $value = $ops[ $i ];
                    }
                    
                    if ( self::validIndex( $i, $ops ) )
                    {
                        Option::setOptionalValue( $option, $value );
                    }
                    else if ( is_bool( $value ) )
                    {
                        Option::setOptionalValue( $option, $value );
                    }
                }
            }
            
            $i++;
        }
        
        $this->doAction( self::ON_AFTER_PROCESS_ARGS_ACTION );
    }
    
    // actions
    const ON_BEFORE_RUN_ACTION          = 'on_before_run_action';
    const ON_AFTER_RUN_ACTION           = 'on_after_run_action';
    
    const ON_BEFORE_GET_COMMAND_ACTION  = 'on_before_get_command_action';
    const ON_AFTER_GET_COMMAND_ACTION   = 'on_after_get_command_action';
    
    const ON_BEFORE_PROCESS_ARGS_ACTION = 'on_before_process_args_action';
    const ON_AFTER_PROCESS_ARGS_ACTION  = 'on_after_process_args_action';
    
    // filters
    const ON_GET_COMMAND_FILTER         = 'on_get_command_filter';
}