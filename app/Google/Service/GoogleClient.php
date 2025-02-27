<?php

declare (strict_types = 1);

namespace App\Google\Service;

class GoogleClient
{
    private $client;
    
    public function __construct()
    {
        $this->client = new \Google_client();
        $this->client->setAuthConfig('client_secret.json');
        $this->client->setAccessType('offline');
        $this->client->setApprovalPrompt("force");

        $this->client->setScopes([
            \Google_Service_YouTube::YOUTUBE_READONLY,
        ]);

        $this->client->setApplicationName('API code samples');
    }

    # Method reutrns object of class \Google_client
    public function get()
    {
        return $this->client;
    }
}