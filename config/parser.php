<?php

return [
    /*
    | Habr home URL
    */
    'parsed_url' => env('PARSED_URL', 'https://habr.com/ru'),
    /*
    | Parsing frequency
    */
    'parser_cron_time' => env('PARSER_CRON_TIME', '*/45 * * * *')
];
