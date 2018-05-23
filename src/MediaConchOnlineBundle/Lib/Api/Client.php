<?php

namespace MediaConchOnlineBundle\Lib\Api;

class Client
{
    protected $apiConfig;

    public function __construct($apiConfig)
    {
        $this->apiConfig = $apiConfig;
    }

    public function getPoliciesCount($userId)
    {
        $policiesCount = $this->callApi(
            '/MediaConchOnline/api/public/v1/policies/count/'.$userId,
            $this->apiConfig['token']
        );

        if (false !== $policiesCount) {
            return $policiesCount->policiesCount;
        }

        return 0;
    }

    protected function callApi($uri, $apiToken = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->apiConfig['baseUrl'].$uri);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Add API token header
        if (null !== $apiToken) {
            $header = ['X-API-TOKEN: '.$apiToken];
        }

        // Add HTTP header
        if (isset($header) && 0 < count($header)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }

        $response = curl_exec($curl);
        $responseCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);

        if (200 == $responseCode) {
            return json_decode($response);
        } else {
            return false;
        }
    }
}
