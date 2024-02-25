<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Image Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default image driver to use when manipulating
    | images. This driver is used when intervention/image is not installed or
    | when the "driver" option in this configuration file is set to null.
    |
    | Supported: "gd", "imagick", "imaginary"
    |
    */

    'driver' => 'imagick',

    /*
    |--------------------------------------------------------------------------
    | Image Driver Connection
    |--------------------------------------------------------------------------
    |
    | When using the "imagick" driver, you may specify its configuration here.
    | These settings will override the default configuration options.
    |
    */

    'drivers' => [

        'imagick' => [
            'library' => 'imagick',
        ],

    ],

];
