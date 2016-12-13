<?php

namespace Qualtrics;

class QualtricsSurveys extends Qualtrics {

  /**
   * Gets information about all templates owned by the authenticated account.
   *
   * @param array $parameters
   *   Associative array of optional request parameters.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/list-surveys
   */
  public function getSurveys($parameters = []) {
    return $this->request('GET', '/surveys', NULL, $parameters);
  }

  /**
   * Gets information a specific survey.
   *
   * @param string $template_id
   *   The ID of the template.
   * @param array $parameters
   *   Associative array of optional request parameters.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/docs/get-survey
   */
  public function getSurvey($survey_id, $parameters = []) {
    $tokens = [
      'surveyId' => $survey_id,
    ];

    return $this->request('GET', '/surveys/{surveyId}', $tokens, $parameters);
  }

}
