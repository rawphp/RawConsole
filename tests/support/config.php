<?php

return
    [
        'debug'              => TRUE,
        'class'              => 'RawPHP\\RawConsole\\Console',
        'command_namespaces' =>
            [
                'RawPHP\\RawConsole\\',
                'RawPHP\\RawConsole\\Tests\\',
                'RawPHP\\RawConsole\\Foreign1\\Tests\\',
                'RawPHP\\RawConsole\\Foreign2\\Tests\\',
            ],
    ];
