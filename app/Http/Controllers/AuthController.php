<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function getFormLogin()
    {
        $currentUrl = url()->previous();
        // dd($currentUrl);
        // dd(base64_encode(env('COGNITO_CLIENT_ID'). ':' . env('COGNITO_CLIENT_SECRET')));
        //Mjk0ODlqbmltajZxc244NHFzb2t1NjN1bmg6NnEzdmVnbnUwbGxzcG0wZGgxcDd2YjRjc25rdjA3ZTNwaWgyOGY1OWFqMTI1Z3BwMTk=

        session()->put('previous_url', $currentUrl);
        $loginUrl = 'https://local-sys.auth.us-east-1.amazoncognito.com/login?client_id=29489jnimj6qsn84qsoku63unh&response_type=code&scope=email+openid+phone&redirect_uri=http%3A%2F%2Flocalhost%3A8000%2Foauth2%2Fidpresponse';
        return redirect($loginUrl);
    }

    public function handleCognitoCallback(Request $request)
    {
        $code = $request->query('code');
        //use code to get name of user in cognito
        $credentials = base64_encode(env('COGNITO_CLIENT_ID') . ':' . env('COGNITO_CLIENT_SECRET'));
        $tokenResponse =  Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic ' . $credentials,
        ])
            ->post(env('COGNITO_TOKEN_URL'), [
                'grant_type' => 'authorization_code',
                'client_id' => env('COGNITO_CLIENT_ID'),

                'code' => $code,
                'redirect_uri' => env('COGNITO_REDIRECT_URI'),
            ]);
        // $status = $response->status();
        // $body = $response->body();
        // dd($status, $body);
        $accessToken = $tokenResponse['access_token'];
        $userData = Http::withToken($accessToken)
        ->withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
        ])
        ->get(env('COGNITO_USERINFO_URL'));
        if ($userData->successful()) {
            $userName = $userData->json()['name'];
            session()->put('user_name', $userName);
            // Use the access token for further requests or store it in the session
            if (session()->has('previous_url')) {
                $previousUrl = session()->pull('previous_url');
                return redirect($previousUrl);
            } else {
                return redirect('/index');
            }
        } else {
            // Error occurred while retrieving the access token
            $error = $userData->json()['error'];
            $errorMessage = $userData->json()['error_description'];
            dd($error, $errorMessage);
        }
    }
}
