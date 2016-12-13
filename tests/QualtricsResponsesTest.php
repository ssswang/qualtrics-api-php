<?php

namespace Qualtrics\Tests;

class QualtricsResponsesTest extends \PHPUnit_Framework_TestCase {

  /**
   * Tests library functionality for report information.
   */
  public function testGetSummary() {
    $qt = new QualtricsResponses();
    $qt->getSummary();

    $this->assertEquals('GET', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/reports', $qt->getClient()->uri);
  }

  /**
   * Tests library functionality for campaign report information.
   */
  public function testCampaignSummary() {
    $campaign_id = '42694e9e57';

    $qt = new QualtricsResponses();
    $qt->getCampaignSummary($campaign_id);

    $this->assertEquals('GET', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/reports/' . $campaign_id, $qt->getClient()->uri);
  }

}
