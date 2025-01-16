<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class EurekaService
{
  protected $client;
  protected $eurekaUrl;
  protected $appName;
  protected $instanceId;
  protected $auth;

  public function __construct()
  {
    $this->client = new Client();
    $this->eurekaUrl = env('EUREKA_URL', 'http://user:133336f1-84f5-4e04-9e72-7b8e1de16308@localhost:8761/eureka');
    $this->appName = env('EUREKA_APP_NAME', 'MY_LARAVEL_APP');
    $this->instanceId = env('EUREKA_INSTANCE_ID', 'localhost:my-laravel-app:8000');
    $this->auth = [env('EUREKA_USERNAME'), env('EUREKA_PASSWORD')];
  }

  public function register()
  {
    $instanceInfo = [
      'instance' => [
        'instanceId' => $this->instanceId,
        'hostName' => env('EUREKA_HOSTNAME', 'localhost'),
        'app' => $this->appName,
        'ipAddr' => env('EUREKA_IP_ADDR', '127.0.0.1'),
        'status' => 'UP',
        'port' => [
          '$' => env('EUREKA_PORT', 8000),
          '@enabled' => true,
        ],
      
      ],
    ];

    try {
      $response = $this->client->post($this->eurekaUrl . '/apps/' . $this->appName, [
        'json' => $instanceInfo,
        'auth' => $this->auth,
      ]);

      return $response->getStatusCode();
    } catch (RequestException $e) {
      // Log the exception message
      Log::error('Eureka registration error: ' . $e->getMessage());
      return $e->getMessage();
    }
  }

  public function heartbeat()
  {
    try {
      $response = $this->client->put($this->eurekaUrl . '/apps/' . $this->appName . '/' . $this->instanceId, [
        'auth' => $this->auth,
      ]);

      return $response->getStatusCode();
    } catch (RequestException $e) {
      // Log the exception message
      Log::error('Eureka heartbeat error: ' . $e->getMessage());
      return $e->getMessage();
    }
  }

  public function deregister()
  {
    try {
      $response = $this->client->delete($this->eurekaUrl . '/apps/' . $this->appName . '/' . $this->instanceId, [
        'auth' => $this->auth,
      ]);

      return $response->getStatusCode();
    } catch (RequestException $e) {
      // Log the exception message
      Log::error('Eureka deregistration error: ' . $e->getMessage());
      return $e->getMessage();
    }
  }
}
