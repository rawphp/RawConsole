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
 * @package   RawPHP\RawConsole\Contract
 * @author    Tom Kaczocha <tom@rawphp.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://rawphp.org/license.txt MIT
 * @link      http://rawphp.org/
 */

namespace RawPHP\RawConsole\Contract;

use RawPHP\RawConsole\Exception\CommandException;

/**
 * The Console Interface.
 *
 * @category  PHP
 * @package   RawPHP\RawConsole\Contract
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
     * @throws CommandException in exceptional circumstances
     */
    public function run( $args );

    /**
     * Get the requested command.
     *
     * @param array  $args              command line arguments
     *
     * @global array $commandNamespaces command namespaces
     *
     * @return ICommand the command
     */
    public function getCommand( $args );

    /**
     * Processes the command line arguments and sets the option
     * values for the command.
     *
     * @param ICommand $command the command reference
     * @param array    $args    command line args
     *
     * @throws CommandException
     */
    public function processArgs( ICommand &$command, $args );
}