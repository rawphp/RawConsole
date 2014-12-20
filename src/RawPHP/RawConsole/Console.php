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

use RawPHP\RawConsole\Contract\ICommand;
use RawPHP\RawConsole\Contract\IConsole;
use RawPHP\RawConsole\Exception\CommandException;
use RawPHP\RawSupport\Util;

/**
 * The Console class.
 *
 * @category  PHP
 * @package   RawPHP\RawConsole
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
class Console implements IConsole
{
    /**
     * @var ICommand
     */
    public $command = NULL;
    /**
     * @var array
     */
    public $arguments = [ ];
    /**
     * @var array
     */
    public $namespaces = [ ];

    /**
     * Initialises the console.
     *
     * @param array $config configuration array
     */
    public function init( $config = NULL )
    {
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
     * @throws CommandException in exceptional circumstances
     */
    public function run( $args )
    {
        $this->command = $this->getCommand( $args );

        if ( NULL == $this->command )
        {
            throw new CommandException( 'Command: ' . $args[ 1 ] . ' not found' );
        }

        $this->processArgs( $this->command, $args );

        $this->command->execute();
    }

    /**
     * Get the requested command.
     *
     * @param array  $args              command line arguments
     *
     * @global array $commandNamespaces command namespaces
     *
     * @return ICommand the command
     */
    public function getCommand( $args )
    {
        $class = strtoupper( substr( $args[ 1 ], 0, 1 ) ) . substr( $args[ 1 ], 1 );
        $class .= 'Command';

        /** @var Command $command */
        $command = NULL;

        if ( class_exists( $class ) )
        {
            $command = new $class();
        }

        if ( NULL === $command && !empty( $this->namespaces ) )
        {
            foreach ( $this->namespaces as $ns )
            {
                $name = $ns . $class;

                if ( class_exists( $name ) )
                {
                    $command = new $name();
                    $command->init( $args );

                    break;
                }
            }
        }

        if ( NULL !== $command )
        {
            $command->configure();
        }

        return $command;
    }

    /**
     * Processes the command line arguments and sets the option
     * values for the command.
     *
     * @param ICommand $command the command reference
     * @param array    $args    command line args
     *
     * @throws CommandException
     */
    public function processArgs( ICommand &$command, $args )
    {
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

                    if ( !Util::validIndex( $i, $ops ) )
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

                    if ( Util::validIndex( $i, $ops ) )
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
    }
}