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

namespace RawPHP\RawConsole;

use RawPHP\RawBase\Component;
use RawPHP\RawConsole\Command;
use RawPHP\RawConsole\Option;
use RawPHP\RawConsole\IHelpWriter;

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
class StandardHelpWriter extends Component implements IHelpWriter
{
    /**
     * This method writes the help to the console.
     * 
     * @param Command $command the command instance
     * @param Option  $option  optional option
     * 
     * @action ON_BEFORE_WRITE_HELP_ACTION
     * 
     * @filter ON_WRITE_HELP_FILTER(1)
     * 
     * @action ON_AFTER_WRITE_HELP_ACTION
     */
    public function write( Command $command, Option $option = NULL )
    {
        $this->doAction( self::ON_BEFORE_WRITE_HELP_ACTION );
        
        $output = PHP_EOL;
        $output .= '-----------------------------------------------------' . PHP_EOL;
        $output .= $command->name . ' ' . $command->version . PHP_EOL;
        $output .= '-----------------------------------------------------' . PHP_EOL;
        $output .= $command->copyright . PHP_EOL;
        $output .= $command->description . PHP_EOL;
        $output .= 'Support: ' . $command->supportSite . PHP_EOL;
        $output .= 'Source: ' . $command->supportSource . PHP_EOL;
        $output .= '-----------------------------------------------------' . PHP_EOL . PHP_EOL;
        
        $output .= 'Usage: ' . $this->_getUsageExample( $command );
        
        if ( NULL !== $option && !empty( $option->longDescription ) ) // detailed help for single option
        {
            $output .= $option->longDescription . PHP_EOL;
        }
        else // short overview of each option
        {
            $str = '';
            
            foreach( $command->options as $option )
            {
                $str .= sprintf( " --%-8s (-%s) %-6s%s", 
                        $option->longCode, $option->shortCode, $option->shortDescription, PHP_EOL );
            }
            
            $output .= $str;
        }
        
        echo $this->filter( self::ON_WRITE_HELP_FILTER, $output );
        
        $this->doAction( self::ON_AFTER_WRITE_HELP_ACTION );
    }
    
    /**
     * Prepares the command usage example.
     * 
     * @param Command $command the command
     * 
     * @return string the command usage example string
     */
    private function _getUsageExample( Command $command )
    {
        $name = strtolower( str_replace( 'Command', '', get_class( $command ) ) );
        
        if ( FALSE !== strstr( $name, "\\" ) )
        {
            $pts = explode( "\\", $name );
            
            $name = $pts[ count( $pts ) - 1 ];
        }
        
        $usage = './' . $name . ' --' . $command->options[ 0 ]->longCode;
        
        return $this->filter( self::ON_GET_USAGE_EXAMPLE_FILTER, $usage . PHP_EOL . PHP_EOL, $command );
    }
    
    // actions
    const ON_BEFORE_WRITE_HELP_ACTION   = 'on_before_write_help_action';
    const ON_AFTER_WRITE_HELP_ACTION    = 'on_after_write_help_action';
    
    // filters
    const ON_WRITE_HELP_FILTER          = 'on_write_help_filter';
    const ON_GET_USAGE_EXAMPLE_FILTER   = 'on_get_usage_example_filter';
}
