<?php

/**
 * This file is part of Step in Deals application.
 *
 * Copyright (c) 2014 Tom Kaczocha
 *
 * This Source Code is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, you can obtain one at http://mozilla.org/MPL/2.0/.
 *
 * PHP version 5.4
 *
 * @category  PHP
 * @package   RawPHP\RawConsole\Event
 * @author    Tom Kaczocha <tom@crazydev.org>
 * @copyright 2014 Tom Kaczocha
 * @license   http://crazydev.org/licenses/mpl.txt MPL
 * @link      http://crazydev.org/
 */

namespace RawPHP\RawConsole\Event;

use RawPHP\RawDispatcher\Event;

/**
 * Class WriteHelpEvent
 *
 * @package RawPHP\RawConsole\Event
 */
class WriteHelpEvent extends Event
{
    protected $helpText;

    public function __construct( $text = '' )
    {
        $this->helpText = $text;
    }

    /**
     * @return mixed
     */
    public function getHelpText()
    {
        return $this->helpText;
    }

    /**
     * @param mixed $helpText
     */
    public function setHelpText( $helpText )
    {
        $this->helpText = $helpText;
    }
}
