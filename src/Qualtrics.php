<?php

namespace Qualtrics;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Qualtrics {

  const VERSION = '0.1-alpha';
  const DEFAULT_DATA_CENTER = 'co1';

  const ERROR_CODE_BAD_REQUEST = 'BadRequest';
  const ERROR_CODE_INVALID_ACTION = 'InvalidAction';
  const ERROR_CODE_INVALID_RESOURCE = 'InvalidResource';
  const ERROR_CODE_JSON_PARSE_ERROR = 'JSONParseError';
  const ERROR_CODE_API_KEY_MISSING = 'APIKeyMissing';
  const ERROR_CODE_API_KEY_INVALID = 'APIKeyInvalid';
  const ERROR_CODE_FORBIDDEN = 'Forbidden';
  const ERROR_CODE_USER_DISABLED = 'UserDisabled';
  const ERROR_CODE_WRONG_DATACENTER = 'WrongDatacenter';
  const ERROR_CODE_RESOURCE_NOT_FOUND = 'ResourceNotFound';
  const ERROR_CODE_METHOD_NOT_ALLOWED = 'MethodNotAllowed';
  const ERROR_CODE_RESOURCE_NESTING_TOO_DEEP = 'ResourceNestingTooDeep';
  const ERROR_CODE_INVALID_METHOD_OVERRIDE = 'InvalidMethodOverride';
  const ERROR_CODE_REQUESTED_FIELDS_INVALID = 'RequestedFieldsInvalid';
  const ERROR_CODE_TOO_MANY_REQUESTS = 'TooManyRequests';
  const ERROR_CODE_INTERNAL_SERVER_ERROR = 'InternalServerError';
  const ERROR_CODE_COMPLIANCE_RELATED = 'ComplianceRelated';

  /**
   * API version.
   * @var string
   */
  public $version = self::VERSION;

  /**
   * @var Client $client
   *   The GuzzleHttp Client.
   */
  protected $client;

  /**
   * @var string $endpoint
   *   The REST API endpoint.
   */
  protected $endpoint = 'https://co1.qualtrics.com/API/v3';

  /**
   * @var string $api_key
   *   The Qualtrics API key to authenticate with.
   */
  private $api_key;

  /**
   * @var string $api_user
   *   The Qualtrics API username to authenticate with.
   */
  private $api_user;

  /**
   * @var string $debug_error_code
   *   A Qualtrics API error code to return with every API response.
   *   Used for testing / debugging error handling.
   *   See ERROR_CODE_* constants.
   */
  private $debug_error_code;

  /**
   * Qualtrics constructor.
   *
   * @param string $api_key
   *   The Qualtrics API key.
   *
   * @param string $api_user
   *   The Qualtrics API username.
   *
   * @param int $timeout
   *   Maximum request time in seconds.
   */
  public function __construct($api_key, $api_user, $timeout = 10) {
    $this->api_key = $api_key;
    $this->api_user = $api_user;

    $this->client = new Client([
      'timeout' => $timeout,
    ]);
  }

  /**
   * Sets a Qualtrics error code to be returned by all requests.
   * Used to test and debug error handling.
   *
   * @param string $error_code
   *   The Qualtrics error code.
   */
  public function setDebugErrorCode($error_code) {
    $this->debug_error_code = $error_code;
  }

  /**
   * Gets Qualtrics account information for the authenticated account.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/get-user
   */
  public function getAccount() {

    $tokens = [
      'userid' => $this->api_user,
    ];

    return $this->request('GET', '/users/{userid}', $tokens);
  }

  /**
   * Makes a request to the Qualtrics API.
   *
   * @param string $method
   *   The REST method to use when making the request.
   * @param string $path
   *   The API path to request.
   * @param array $tokens
   *   Associative array of tokens and values to replace in the path.
   * @param array $parameters
   *   Associative array of parameters to send in the request body.
   * @param bool $batch
   *   TRUE if this request should be added to pending batch operations.
   *
   * @return object
   *
   * @throws QualtricsAPIException
   */
  protected function request($method, $path, $tokens = NULL, $parameters = NULL, $batch = FALSE) {
    if (!empty($tokens)) {
      foreach ($tokens as $key => $value) {
        $path = str_replace('{' . $key . '}', $value, $path);
      }
    }

    // if ($batch) {
    //   return $this->addBatchOperation($method, $path, $parameters);
    // }

    // Set default request options with auth header.
    $options = [
      'headers' => [
        //'Authorization' => $this->api_user . ' ' . $this->api_key,
        'X-API-TOKEN' => $this->api_key,
      ],
    ];

    // Add trigger error header if a debug error code has been set.
    if (!empty($this->debug_error_code)) {
      $options['headers']['X-Trigger-Error'] = $this->debug_error_code;
    }

    if (!empty($parameters)) {
      if ($method == 'GET') {
        // Send parameters as query string parameters.
        $options['query'] = $parameters;
      }
      else {
        // Send parameters as JSON in request body.
        $options['json'] = (object) $parameters;
      }
    }

    try {
      $response = $this->client->request($method, $this->endpoint . $path, $options);
      $data = json_decode($response->getBody());

      return $data;

    }
    catch (RequestException $e) {
      $response = $e->getResponse();
      if (!empty($response)) {
        $message = $e->getResponse()->getBody();
      }
      else {
        $message = $e->getMessage();
      }

      throw new QualtricsAPIException($message, $e->getCode(), $e);
    }
  }

  /**
   * Gets the ID of the data center associated with an API key.
   *
   * @param string $api_key
   *   The Qualtrics API key.
   *
   * @return string
   *   The data center ID.
   */
  private function getDataCenter($api_key) {
    $api_key_parts = explode('-', $api_key);

    return (isset($api_key_parts[1])) ? $api_key_parts[1] : Qualtrics::DEFAULT_DATA_CENTER;
  }

}
