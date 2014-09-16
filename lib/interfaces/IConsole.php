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

/**
 * The Console Interface.
 * 
 * @category  PHP
 * @package   RawPHP/RawConsole
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */
interface IConsole
{
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
    public function run( $args );
    
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
    public function getCommand( $args );
    
    /**
     * Processes the command line arguments and sets the option
     * values for the command.
     * 
     * @param ICommand &$command the command reference
     * @param array    $args     command line args
     * 
     * @action ON_BEFORE_PROCESS_ARGS_ACTION
     * @action ON_AFTER_PROCESS_ARGS_ACTION
     * 
     * @throws CommandException
     */
    public function processArgs( Command &$command, $args );
}
