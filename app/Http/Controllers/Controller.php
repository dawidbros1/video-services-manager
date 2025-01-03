<?php

namespace App\Http\Controllers;

use App\Service\Google;
use App\Helper\Session;

abstract class Controller
{
    protected $user = null;
    protected $google;

    public function __construct() {
        $this->google = new Google(env('PROJECT_LOCATION'));
        $this->user = $this->google->login();
    }
}
