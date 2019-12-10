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

}
