<?php

namespace Qualtrics\Tests;

class QualtricsContactsTest extends \PHPUnit_Framework_TestCase {

  /**
   * Tests library functionality for lists information.
   */
  public function testGetLists() {
    $qt = new QualtricsContacts();
    $qt->getLists();

    $this->assertEquals('GET', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/mailinglists', $qt->getClient()->uri);
  }

  /**
   * Tests library functionality for list information.
   */
  public function testGetList() {
    $list_id = 'ML_0p3AGyJ69wXiqeF';

    $qt = new QualtricsContacts();
    $qt->getList($list_id);

    $this->assertEquals('GET', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/mailinglists/' . $list_id, $qt->getClient()->uri);
  }


  /**
   * Tests library functionality for contacts information.
   */
  public function testGetContacts() {
    $list_id = 'ML_0p3AGyJ69wXiqeF';

    $qt = new QualtricsContacts();
    $qt->getContacts($list_id);

    $this->assertEquals('GET', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/mailinglists/' . $list_id . '/contacts', $qt->getClient()->uri);
  }

  /**
   * Tests library functionality for member information.
   */
  public function testGetContactInfo() {
    $list_id = 'ML_0p3AGyJ69wXiqeF';
    $contact_id = 'test@example.com';

    $qt = new QualtricsContacts();
    $qt->getContactInfo($list_id, $email);

    $this->assertEquals('GET', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/mailinglists/' . $list_id . '/contacts/' . $contact_id, $qt->getClient()->uri);
  }

  /**
   * Tests library functionality for adding a list member.
   */
  public function testAddContact() {
    $list_id = 'ML_0p3AGyJ69wXiqeF';
    $email = 'test@example.com';

    $qt = new QualtricsContacts();
    $qt->addContact($list_id, $email);

    $this->assertEquals('POST', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/mailinglists/' . $list_id . '/contacts', $qt->getClient()->uri);

    $this->assertNotEmpty($qt->getClient()->options['json']);

    $request_body = $qt->getClient()->options['json'];

    $this->assertEquals($email, $request_body->email_address);
  }

  /**
   * Tests library functionality for removing a list member.
   */
  public function testRemoveContact() {
    $list_id = 'ML_0p3AGyJ69wXiqeF';
    $contact_id = 'test@example.com';

    $qt = new QualtricsContacts();
    $qt->removeContact($list_id, $contact_id);

    $this->assertEquals('DELETE', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/mailinglists/' . $list_id . '/contacts/' . $contact_id, $qt->getClient()->uri);
  }

  /**
   * Tests library functionality for updating a list member.
   */
  public function testUpdateContact() {
    $list_id = 'ML_0p3AGyJ69wXiqeF';
    $contact_id = 'test@example.com';

    $qt = new QualtricsContacts();
    $qt->updateContact($list_id, $contact_id);

    $this->assertEquals('PUT', $qt->getClient()->method);
    $this->assertEquals($qt->getEndpoint() . '/mailinglists/' . $list_id . '/contacts/' . $contact_id, $qt->getClient()->uri);
  }


}
