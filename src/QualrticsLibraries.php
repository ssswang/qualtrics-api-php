<?php

namespace Qualtrics;

class QualtricsLibraries extends Qualtrics {

  /**
   * Gets a report summary for the authenticated account.
   * @param string $library_id
   *   The ID of the library.
   * @param array $parameters
   *   Associative array of optional request parameters.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/get-library-messages
   */
  public function getLibraryMessages($library_id, $parameters = []) {
    $tokens = [
      'libraryId' => $library_id,
    ];

    return $this->request('GET', '/libraries/{libraryId}', $tokens, $parameters);
  }

  /**
   * Gets a report summary for a specific campaign.
   *
   * @param string $library_id
   *   The ID of the campaign.
   * @param string $message_id
   *   The ID of the message.
   * @param array $parameters
   *   Associative array of optional request parameters.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/get-library-message
   */
  public function getLibraryMessage($library_id, $message_id, $parameters = []) {
    $tokens = [
      'libraryId' => $library_id,
      'messageId' => $message_id,
    ];

    return $this->request('GET', '/libraries/{libraryId}/messages/{messageId}', $tokens, $parameters);
  }

}
