<?php

namespace Qualtrics\Tests;

class QualtricsDistributions extends \PHPUnit_Framework_TestCase {

  /**
   * Tests library functionality for campaigns information.
   */
  public function testGetCampaigns() {
    $qt = new QualtricsDistributions();
    $qt->getCampaigns();

    $this->assertEquals('GET', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/campaigns', $qt->getClient()->uri);
  }

  /**
   * Tests library functionality for campaign information.
   */
  public function testGetCampaign() {
    $campaign_id = '42694e9e57';

    $qt = new QualtricsDistributions();
    $qt->getCampaign($campaign_id);

    $this->assertEquals('GET', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/campaigns/' . $campaign_id, $qt->getClient()->uri);
  }

  /**
   * Tests library functionality for adding a new campaign.
   */
  public function testAddCampaign() {
    $type = 'regular';
    $recipients = (object) [
      'list_id' => '3c307a9f3f',
    ];
    $settings = (object) [
      'subject_line' => 'Your Purchase Receipt',
      'from_name' => 'Customer Service',
    ];

    $qt = new QualtricsDistributions();
    $qt->addCampaign($type, $recipients, $settings);

    $this->assertEquals('POST', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/campaigns', $qt->getClient()->uri);

    $this->assertNotEmpty($qt->getClient()->options['json']);

    $request_body = $qt->getClient()->options['json'];

    $this->assertEquals($type, $request_body->type);

    $this->assertEquals($recipients->list_id, $request_body->recipients->list_id);
    $this->assertEquals($settings->subject_line, $request_body->settings->subject_line);
    $this->assertEquals($settings->from_name, $request_body->settings->from_name);
  }

  /**
   * Tests library functionality for setting campaign content.
   */
  public function testSetCampaignContent() {
    $campaign_id = '42694e9e57';
    $parameters = [
      'html' => '<p>The HTML to use for the saved campaign.</p>',
    ];

    $qt = new QualtricsDistributions();
    $qt->setCampaignContent($campaign_id, $parameters);

    $this->assertEquals('PUT', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/campaigns/' . $campaign_id . '/content', $qt->getClient()->uri);

    $this->assertNotEmpty($qt->getClient()->options['json']);

    $request_body = $qt->getClient()->options['json'];

    $this->assertEquals($parameters['html'], $request_body->html);
  }

  /**
   * Tests library functionality for updating a campaign.
   */
  public function testUpdateCampaign() {
    $campaign_id = '3e06f4ec92';
    $type = 'regular';
    $recipients = (object) [
      'list_id' => '3c307a9f3f',
    ];
    $settings = (object) [
      'subject_line' => 'This is an updated subject line',
      'from_name' => 'Customer Service',
    ];

    $qt = new QualtricsDistributions();
    $qt->updateCampaign($campaign_id, $type, $recipients, $settings);

    $this->assertEquals('PATCH', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/campaigns/' . $campaign_id, $qt->getClient()->uri);

    $this->assertNotEmpty($qt->getClient()->options['json']);

    $request_body = $qt->getClient()->options['json'];

    $this->assertEquals($type, $request_body->type);

    $this->assertEquals($recipients->list_id, $request_body->recipients->list_id);
    $this->assertEquals($settings->subject_line, $request_body->settings->subject_line);
    $this->assertEquals($settings->from_name, $request_body->settings->from_name);
  }

  /**
   * Tests library functionality for sending a test campaign.
   */
  public function testSendTest() {
    $campaign_id = 'b03bfc273a';
    $emails = [
      'test@example.com',
    ];
    $send_type = 'html';

    $qt = new QualtricsCampaigns();
    $qt->sendTest($campaign_id, $emails, $send_type);

    $this->assertEquals('POST', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/campaigns/' . $campaign_id . '/actions/test', $qt->getClient()->uri);
  }

  /**
   * Tests library functionality for sending a campaign.
   */
  public function testSend() {
    $campaign_id = 'b03bfc273a';

    $qt = new QualtricsDistributions();
    $qt->send($campaign_id);

    $this->assertEquals('POST', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/campaigns/' . $campaign_id . '/actions/send', $qt->getClient()->uri);
  }

  /**
   * Tests library functionality for campaigns information.
   */
  public function testDelete() {
    $campaign_id = '42694e9e57';

    $qt = new QualtricsDistributions();
    $qt->delete($campaign_id);

    $this->assertEquals('DELETE', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/campaigns/' . $campaign_id, $qt->getClient()->uri);
  }

}
