<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Service\Google;
use App\Helper\Session;

// odpowiada za ustawianie sesji GOOGLE

class GoogleController extends Controller
{
    # Wyświetlenie strony do logowania przez konto Google
    public function index() 
    {
        return view('google.authorization', [
            'google_login_url' => $this->google->getGoogleLoginUrl(),
            'value' => Session::get('access_token')
        ]);
    }

    # Back from google_login_url => save access_token to session
    # Next redirect to main page [ project.location ]
    public function authorization()
    {
        header('Location: ' . filter_var(env('PROJECT_LOCATION'), FILTER_SANITIZE_URL));
        $client = $this->google->getClient();
        $client->authenticate($_GET['code']);
        Session::set('access_token', $client->getAccessToken());
    }

    public function logout()
    {
        $this->google->logout();

        // return $this->redirect('home');
    }
}