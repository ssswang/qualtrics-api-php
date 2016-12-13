<?php

namespace Qualtrics;

class QualtricsContacts extends Qualtrics {

  const MEMBER_STATUS_SUBSCRIBED = 'subscribed';
  const MEMBER_STATUS_UNSUBSCRIBED = 'unsubscribed';
  const MEMBER_STATUS_CLEANED = 'cleaned';
  const MEMBER_STATUS_PENDING = 'pending';

  /**
   * Gets information about all lists owned by the authenticated account.
   *
   * @param array $parameters
   *   Associative array of optional request parameters.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/list-mailing-lists
   */
  public function getLists($parameters = []) {
    return $this->request('GET', '/mailinglists', NULL, $parameters);
  }

  /**
   * Gets a Qualtrics list.
   *
   * @param string $list_id
   *   The ID of the list.
   * @param array $parameters
   *   Associative array of optional request parameters.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/get-mailing-list
   */
  public function getList($list_id, $parameters = []) {
    $tokens = [
      'mailingListId' => $list_id,
    ];

    return $this->request('GET', '/mailinglists/{mailingListId}', $tokens, $parameters);
  }


  /**
   * Gets information about all members of a Qualtrics list.
   *
   * @param string $list_id
   *   The ID of the list.
   * @param array $parameters
   *   Associative array of optional request parameters.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/list-contacts
   */
  public function getContacts($list_id, $parameters = []) {
    $tokens = [
      'mailingListId' => $list_id,
    ];

    return $this->request('GET', '/mailinglists/{mailingListId}/contacts', $tokens, $parameters);
  }

  /**
   * Gets information about a contact of a Qualtrics list.
   *
   * @param string $list_id
   *   The ID of the list.
   * @param string $email
   *   The member's email address.
   * @param array $parameters
   *   Associative array of optional request parameters.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/get-contact
   */
  public function getContactInfo($list_id, $contact_id, $parameters = []) {
    $tokens = [
      'mailingListId' => $list_id,
      'contactId' => $contact_id,
    ];

    return $this->request('GET', '/mailinglists/{mailingListId}/contacts/{contactId}', $tokens, $parameters);
  }

  /**
   * Adds a new member to a Qualtrics list.
   *
   * @param string $list_id
   *   The ID of the list.
   * @param string $email
   *   The email address to add.
   * @param array $parameters
   *   Associative array of optional request parameters.
   * @param bool $batch
   *   TRUE to create a new pending batch operation.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/create-recipient-contact
   */
  public function addContact($list_id, $email, $parameters = []) {
    $tokens = [
      'mailingListId' => $list_id,
    ];

    $parameters += [
      'email' => $email,
    ];

    return $this->request('POST', '/mailinglists/{mailingListId}/contacts', $tokens, $parameters);
  }

  /**
   * Removes a member from a Qualtrics list.
   *
   * @param string $list_id
   *   The ID of the list.
   * @param string $email
   *   The member's email address.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/delete-contact
   */
  public function removeContact($list_id, $contact_id) {
    $tokens = [
      'mailingListId' => $list_id,
      'contactId' => $contact_id,
    ];

    return $this->request('DELETE', '/mailinglists/{mailingListId}/contacts/{contactId}', $tokens);
  }

  /**
   * Updates a member of a Qualtrics list.
   *
   * @param string $list_id
   *   The ID of the list.
   * @param string $email
   *   The member's email address.
   * @param array $parameters
   *   Associative array of optional request parameters.
   * @param bool $batch
   *   TRUE to create a new pending batch operation.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/update-contact
   */
  public function updateContact($list_id, $contact_id, $parameters = []) {
    $tokens = [
      'mailingListId' => $list_id,
      'contactId' => $contact_id,
    ];

    return $this->request('PUT', '/mailinglists/{mailingListId}/contacts/{contactId}', $tokens, $parameters);
  }


  /**
   * Gets all lists an email address is subscribed to.
   *
   * @param string $email
   *   The email address to get lists for.
   *
   * @return array
   *   Array of subscribed list objects.
   *
   * @throws QualtricsAPIException
   */
  public function getListsForContactID($contact_id) {
    $list_data = $this->getLists();

    $subscribed_lists = [];

    // Check each list for a subscriber matching the email address.
    if ($list_data->total_items > 0) {
      foreach ($list_data->lists as $list) {
        try {
          $member_data = $this->getContactInfo($list->id, $contact_id);

          if (isset($member_data->id)) {
            $subscribed_lists[] = $list;
          }
        }
        catch (QualtricsAPIException $e) {
          if ($e->getCode() !== 404) {
            // 404 indicates the email address is not subscribed to this list
            // and can be safely ignored. Surface all other exceptions.
            throw new QualtricsAPIException($e->getResponse()->getBody(), $e->getCode(), $e);
          }
        }
      }
    }

    return $subscribed_lists;
  }

}
