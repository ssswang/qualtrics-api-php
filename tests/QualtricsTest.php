<?php

namespace Qualtrics\Tests;

class QualtricsTest extends \PHPUnit_Framework_TestCase {

  /**
   * Tests library functionality for account information.
   */
  public function testGetAccount() {
    $qt = new Qualtrics();
    $qt->getAccount();

    $this->assertEquals('GET', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/', $qt->getClient()->uri);
  }

  /**
   * Test the version number.
   */
  public function testVersion() {
    $qt = new Qualtrics();
    $this->assertEquals($qt::VERSION, '1.0.0-alpha');
    $this->assertEquals(json_decode(file_get_contents('composer.json'))->version, $qt::VERSION);
  }
}
