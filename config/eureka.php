<?php



return [
  'host' => env('EUREKA_HOST', 'http://localhost:8761'),
  'port' => env('EUREKA_PORT', 8761),
  'app_name' => env('EUREKA_APP_NAME', 'LaravelApp'),
  'ip_address' => env('EUREKA_IP_ADDRESS', '127.0.0.1'),
  'port_number' => env('APP_PORT', 8000),
  'status' => env('EUREKA_STATUS', 'UP'),
  'renew_interval' => env('EUREKA_RENEW_INTERVAL', 30),
  'duration_in_secs' => env('EUREKA_DURATION_IN_SECS', 90),
];
