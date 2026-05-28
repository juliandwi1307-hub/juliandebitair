<?php

return [
    'host'      => env('MQTT_HOST', 'localhost'),
    'port'      => (int) env('MQTT_PORT', 8883),
    'username'  => env('MQTT_USERNAME'),
    'password'  => env('MQTT_PASSWORD'),
    'client_id' => env('MQTT_CLIENT_ID', 'laravel-juliandebitair'),
];
