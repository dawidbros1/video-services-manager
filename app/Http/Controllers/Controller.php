<?php

namespace App\Http\Controllers;

use App\Google\Service\Google;
use App\Helper\Session;

abstract class Controller
{
    protected $google;
    protected $youtube_user = null;
  
    public function __construct() {
        # Inicjalizacja konta Google
        $this->google = new Google(env('PROJECT_LOCATION'));

        # Logowanie konta Google do Youtube
        $this->youtube_user = $this->google->login();
    }
}
