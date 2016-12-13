<?php

namespace Qualtrics\Tests;

class QualtricsSurveysTest extends \PHPUnit_Framework_TestCase {

  /**
   * Tests library functionality for templates information.
   */
  public function testGetTemplates() {
    $qt = new QualtricsSurveys();
    $qt->getTemplates();

    $this->assertEquals('GET', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/templates', $qt->getClient()->uri);
  }

  /**
   * Tests library functionality for template information.
   */
  public function testGetTemplate() {
    $template_id = '2000094';

    $qt = new QualtricsSurveys();
    $qt->getTemplate($template_id);

    $this->assertEquals('GET', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/templates/' . $template_id, $qt->getClient()->uri);
  }

  /**
   * Tests library functionality for template content information.
   */
  public function testGetTemplateContent() {
    $template_id = '2000094';

    $qt = new QualtricsSurveys();
    $qt->getTemplateContent($template_id);

    $this->assertEquals('GET', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/templates/' . $template_id . '/default-content', $qt->getClient()->uri);
  }

}
