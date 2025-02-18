<?php
namespace SellerLedger;

class SellerLedger
{
  const VERSION = '1.2.0';
  const DEFAULT_API_URL = 'https://app.sellerledger.com/v1';

  protected $client;
  protected $config;

  public function __construct($key)
  {
    if ($key) {
      $this->config = [
        'base_uri' => self::DEFAULT_API_URL . '/',
        'handler' => $this->errorHandler(),
        'headers' => [
          'Authorization' => 'Bearer ' . $key,
          'Content-Type' => 'application/json',
          'User-Agent' => $this->getUserAgent()
        ]
      ];
      $this->client = new \GuzzleHttp\Client($this->config);
    } else {
      throw new Exception('Please provide an API key.');
    }
  }

  private function errorHandler() {
    $handler = \GuzzleHttp\HandlerStack::create();
    $handler->push(\GuzzleHttp\Middleware::mapResponse(function ($response) {
      if ($response->getStatusCode() >= 400) {
        $data = json_decode($response->getBody());

        throw new Exception(
          sprintf(
            '%s – %s',
            $response->getStatusCode(),
            isset($data->error) ? $data->error : 'something unexpected occurred'
          ),
          $response->getStatusCode()
        );
      }

      return $response;
    }));

    return $handler; 
  }

  private function refreshClient($config)
  {
    $this->client = new \GuzzleHttp\Client($config);
  }

  public function setApiConfig($index, $value)
  {
    if ($index == 'headers') {
      $value = array_merge($this->config[$index], $value);
    }

    $this->config[$index] = $value;
    $this->refreshClient($this->config);
  }

  public function getApiConfig($index)
  {
    if ($index) {
      return $this->config[$index];
    } else {
      return $this->config;
    }
  }

  private function getUserAgent()
  {
    $os = function_exists('php_uname') ? php_uname('a') : '';
    $php = 'PHP ' . PHP_VERSION;
    $curl = function_exists('curl_version') ? 'cURL ' . curl_version()['version'] : '';
    $openSSL = defined('OPENSSL_VERSION_TEXT') ? OPENSSL_VERSION_TEXT : '';

    return "SellerLedger/PHP ($os; $php; $curl; $openSSL) seller_ledger-php/" . self::VERSION;
  }
}
