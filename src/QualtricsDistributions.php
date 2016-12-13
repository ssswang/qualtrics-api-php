<?php

namespace Qualtrics;

class QualtricsDistributions extends Qualtrics {

  const EMAIL_TYPE_HTML = 'html';
  const EMAIL_TYPE_PLAIN_TEXT = 'plain_text';

  const CAMPAIGN_TYPE_REGULAR = 'regular';
  const CAMPAIGN_TYPE_PLAINTEXT = 'plaintext';
  const CAMPAIGN_TYPE_ABSPLIT = 'absplit';
  const CAMPAIGN_TYPE_RSS = 'rss';
  const CAMPAIGN_TYPE_VARIATE = 'variate';

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
    $parameters += [
      'surveyLink' => $survey_link,
      'header' => $header,
      'message' => $message,
      'recipients' => $recipients,
      'sendDate' => $send_date,
    ];

    return $this->request('POST', '/campaigns', NULL, $parameters);
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

  /**
   * Sends a test email.
   *
   * @param string $campaign_id
   *   The ID of the campaign.
   * @param array $test_emails
   *   Email addresses to send the test email to.
   * @param string $send_type
   *   The type of test email to send.
   * @param array $parameters
   *   Associative array of optional request parameters.
   * @param bool $batch
   *   TRUE to create a new pending batch operation.
   *
   * @return object
   *
   * @see http://developer.mailchimp.com/documentation/mailchimp/reference/campaigns/#action-post_campaigns_campaign_id_actions_test
   */
  public function sendTest($campaign_id, $test_emails, $send_type, $parameters = [], $batch = FALSE) {
    $tokens = [
      'campaign_id' => $campaign_id,
    ];

    $parameters += [
      'test_emails' => $test_emails,
      'send_type' => $send_type,
    ];

    return $this->request('POST', '/campaigns/{campaign_id}/actions/test', $tokens, $parameters, $batch);
  }

  /**
   * Send a MailChimp campaign.
   *
   * @param string $campaign_id
   *   The ID of the campaign.
   * @param bool $batch
   *   TRUE to create a new pending batch operation.
   *
   * @return object
   *
   * @see http://developer.mailchimp.com/documentation/mailchimp/reference/campaigns/#action-post_campaigns_campaign_id_actions_send
   */
  public function send($campaign_id, $batch = FALSE) {
    $tokens = [
      'campaign_id' => $campaign_id,
    ];

    return $this->request('POST', '/campaigns/{campaign_id}/actions/send', $tokens, NULL, $batch);
  }

  /**
   * Deletes a Qualtrics campaign.
   *
   * @param string $campaign_id
   *   The ID of the campaign.
   *
   * @return object
   *
   * @see http://developer.mailchimp.com/documentation/mailchimp/reference/campaigns/#delete-delete_campaigns_campaign_id
   */
  public function delete($campaign_id) {
    $tokens = [
      'campaign_id' => $campaign_id,
    ];

    return $this->request('DELETE', '/campaigns/{campaign_id}', $tokens);
  }

}
