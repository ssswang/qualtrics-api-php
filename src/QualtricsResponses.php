  /**
   * Gets a report summary for the authenticated account.
   *
   * @param array $parameters
   *   Associative array of optional request parameters.
   *
   * @return object
   *
   * @see https://api.qualtrics.com/reference#create-response-export-new
   */
    public function createResponseExport($id, $progressId, $parameters = ["format" => "csv"]) {
        return $this->request('POST', '/surveys/'.$id."/export-responses", NULL, $parameters);
    }
    
    public function createResponseExportProgress($id, $progressId) {
        return $this->request('POST', '/surveys/'.$id."/export-responses/".$progressId);
    }
    public function getResponseExportFile($id, $fileId) {
        return $this->request('GET', '/surveys/'.$id."/export-responses/".$fileId."/file");
    }
