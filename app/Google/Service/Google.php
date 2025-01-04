<?php

declare (strict_types = 1);

namespace App\Google\Service;

use App\Google\Model\GoogleUser;
use App\Helper\Session;
use App\Google\Service\GoogleClient;
use App\Google\YouTube\Rest as YoutubeRest;

class Google
{
    private $client;
    private $url;
    private $youtube_rest;

    public function __construct(string $project_location)
    {
        # Ustawia lokalizację projektu dla autoryzacji konta
        $this->url = $project_location;

        # Zwraca usługę z ustawionymi uprawnieniami i konfiguracją
        # Ustawia uprawnienia do youtube.com
        $this->client = (new GoogleClient())->get();

        # Tworzy rest do odpytywania o dane z API
        $this->youtube_rest = (new YoutubeRest($this->client));
    }

    # Zwraca użytkownika Youtube
    public function login()
    {
        if ($access_token = Session::get('access_token')) {
            $this->validateAccessToken($access_token);

            return 1;

            // return new User($this->youtube->getMyChannel());
        }

        return null;
    }

    # Method logout user
    public function logout()
    {
        Session::clear('access_token');
        $this->client->revokeToken();
    }

    # Method returns link to sign in
    public function getGoogleLoginUrl()
    {
        return filter_var($this->client->createAuthUrl(), FILTER_SANITIZE_URL);
    }

    # Method return GoogleClient
    public function getClient()
    {
        return $this->client;
    }

    # Method return YoutubeService
    public function getYoutubeService()
    {
        return $this->youtube_rest;
    }

    # Method checks if token is set and valid
    # if token is expired =>  refreshToken
    private function validateAccessToken($access_token)
    {
        $this->client->setAccessToken($access_token);

        if ($this->client->isAccessTokenExpired()) {
            $refreshToken = $this->client->getRefreshToken();
            $this->client->refreshToken($refreshToken);
            $newAccessToken = $this->client->getAccessToken();
            $newAccessToken['refresh_token'] = $refreshToken;
            $this->client->setAccessToken($newAccessToken);

            //! unknown error => token is not refresh => safe logout
            if ($this->client->getAccessToken()['access_token'] == Session::get('access_token')['access_token']) {
                header("Location: " . $this->url);
                Session::clear('access_token');
                Session::error("UPS! Coś poszło nie tak! Prosimy o ponowne zalogowanie się");
                exit();
            }

            Session::set('access_tonen', $newAccessToken);
        }
    }
}