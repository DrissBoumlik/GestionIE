<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Custom Parameters
    |--------------------------------------------------------------------------
    |
    | This is a user custom file where you can store values to
    | be used as parameters for the application globally
    */

    /* while importing the table destination choice
    | should be sent with the request so you can
    | just take the index to access the columns
    | you want without if/else conditions
    */
    'db_table_columns' => [
        0 => [
            // columns for the "INSTANCE" table
        ],
        1 => [
            // columns for the "EN COURS" table
        ]
    ],
];
