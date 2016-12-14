<?php

namespace Qualtrics;

class QualtricsDistributions extends Qualtrics {

  const DISTRO_LINK_TYPE_INDIVIDUAL = 'Individual';
  const DISTRO_LINK_TYPE_MULTIPLE = 'Multiple';
  const DISTRO_LINK_TYPE_ANONYMOUS = 'Anonymous';

  /**
   * Gets information about all distributions related to a survey.
   *
   * @param string $survey_id
   *   The surveyId
   * @param array $parameters
   *   Associative array of optional request parameters.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/get-distributions
   */
  public function getDistributions($survey_id, $parameters = []) {

    if (!isset($parameters['surveyId'])) {
      $parameters += [
        'surveyId' => $survey_id,
      ];
    }

    return $this->request('GET', '/distributions', NULL, $parameters);
  }

  /**
   * Gets information about a specific distribution.
   *
   * @param string $distribution_id
   *   The ID of the distribution.
   * @param string $survey_id
   *   The ID of the survey
   * @param array $parameters
   *   Associative array of optional request parameters.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/get-distribution
   */
  public function getDistribution($distribution_id, $survey_id, $parameters = []) {
    $tokens = [
      'distributionId' => $distribution_id,
    ];

    if (!isset($parameters['surveyId'])) {
      $parameters += [
        'surveyId' => $survey_id,
      ];
    }

    return $this->request('GET', '/distributions/{distributionId}', $tokens, $parameters);
  }

  /**
   * Gets a list of distribution links.
   *
   * @param string $distribution_id
   *   The ID of the distribution.
   * @param string $survey_id
   *   The ID of the survey
   * @param array $parameters
   *   Associative array of optional request parameters.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/get-distribution
   */
  public function getDistributionLinks($distribution_id, $survey_id, $parameters = []) {
    $tokens = [
      'distributionId' => $distribution_id,
    ];

    if (!isset($parameters['surveyId'])) {
      $parameters += [
        'surveyId' => $survey_id,
      ];
    }

    return $this->request('GET', '/distributions/{distributionId}/links', $tokens, $parameters);
  }

  /**
   * Adds and sends (or schedules a sending for) a new distribution for a survey.
   *
   * @param array $survey_link
   *   Survey and distro type info.
   * @param array $header
   *   The subject, from name, reply-to, etc settings for the campaign.
   * @param array $recipients
   *   contains mailingListId.
   * @param string $send_date
   *   Time to send the email.
   * @param array $parameters
   *   Associative array of optional request parameters.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/create-survey-distribution
   */
  public function addSurveyDistribution($survey_link, $header, $message, $recipients, $send_date) {
    $parameters = [
      'surveyLink' => $survey_link,
      'header' => $header,
      'message' => $message,
      'recipients' => $recipients,
      'sendDate' => $send_date,
    ];

    return $this->request('POST', '/distributions', NULL, $parameters);
  }

  /**
   * Generates a list of distribution links.
   *
   * @param array $parameters
   *   Associative array of required request parameters.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/generate-distribution-invite
   */
  public function generateDistributionLinks($parameters) {
    $parameters['action'] = 'CreateDistribution';

    return $this->request('POST', '/distributions/', NULL, $parameters);
  }


  /**
   * Create a new distribution with a custom message.
   *
   * @param array $parameters
   *   Associative array of required request parameters.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/generate-distribution-invite
   */
  public function sendEmailToList($parameters) {
    return $this->request('POST', '/distributions/', NULL, $parameters);
  }

}
