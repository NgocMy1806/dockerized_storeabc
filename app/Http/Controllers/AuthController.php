<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Customer;

class AuthController extends Controller
{
    public function getFormLogin()
    {
        $currentUrl = url()->previous();
        // dd(env('COGNITO_TOKEN_URL'));
        // dd($currentUrl);
        // dd(base64_encode(env('COGNITO_CLIENT_ID'). ':' . env('COGNITO_CLIENT_SECRET')));
        //Mjk0ODlqbmltajZxc244NHFzb2t1NjN1bmg6NnEzdmVnbnUwbGxzcG0wZGgxcDd2YjRjc25rdjA3ZTNwaWgyOGY1OWFqMTI1Z3BwMTk=

        session()->put('previousUrl', $currentUrl);
        $loginUrl = env('COGNITO_LOGIN_URL');
        return redirect($loginUrl);
    }

    public function handleCognitoCallback(Request $request)
    {
        try {
            $code = $request->query('code');
            // dd($code);
            //get access token
            $credentials = base64_encode(env('COGNITO_CLIENT_ID') . ':' . env('COGNITO_CLIENT_SECRET'));
            $tokenUrl = env('COGNITO_TOKEN_URL');
            $clientId = env('COGNITO_CLIENT_ID');
            $redirectUri = env('COGNITO_REDIRECT_URI');

            $requestUrl = "{$tokenUrl}?grant_type=authorization_code&client_id={$clientId}&code={$code}&redirect_uri={$redirectUri}";

            //  dd($credentials, $code);
            $tokenResponse =  Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Basic ' . $credentials,
            ])
                ->post($requestUrl);


            $status = $tokenResponse->status();
            $body = $tokenResponse->body();
            // dump($status, $body);
            $accessToken = $tokenResponse->json()['access_token'];
            // dump($accessToken);

            //get user infor by userinfor endpoint
            $userInforUrl = env('COGNITO_USERINFO_URL');
            $userData = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])
                ->get($userInforUrl);

            if ($userData->successful()) {
                $userName = $userData->json()['name'];
                $cognitoId = $userData->json()['sub'];
                $userEmail = $userData->json()['email']; // cognito ID
                $customer = Customer::where('email', $userEmail)->first();

                if (!$customer) {
                    // Customer does not exist, create a new record
                    $customer = Customer::create([
                        'name'=> $userName,
                        'email' => $userEmail,
                        'cognito_id' => $cognitoId, 
                    ]);
                }
                elseif(isset($customer) && $customer->cognito_id ==null)
                {
                    $customer->update([
                        'cognito_id' => $cognitoId,
                    ]);
                }

                $userId = $customer->id;
                // dd($userId);
                session()->put('userName', $userName);
                session()->put('userId', $userId);
                // Use the access token for further requests or store it in the session
                if (session()->has('previousUrl')) {
                    $previousUrl = session()->pull('previousUrl');
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
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function handleALBCallback(Request $request)
{
    // Retrieve user information from ALB headers
    $accessToken = $request->header('x-amzn-oidc-accesstoken');
    $identity = $request->header('x-amzn-oidc-identity');
    $userData = json_decode(base64_decode($request->header('x-amzn-oidc-data')), true);

    // Extract user details from the user claims
    $userName = $userData['name'];
    $userEmail = $userData['email'];

    // Store the user information in the session or perform any other necessary actions
    session()->put('accessToken', $accessToken);
    session()->put('userName', $userName);
    session()->put('userEmail', $userEmail);

    // Redirect the user to the desired page
    return redirect('/dashboard');
}

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $clientId = env('COGNITO_CLIENT_ID');
        $logoutUrl = env('COGNITO_LOGOUT_URL');
        $logoutRedirectUri = env('COGNITO_LOGOUT_REDIRECT_URI');
        $requestUrl = "{$logoutUrl}?client_id={$clientId}&redirect_uri={$logoutRedirectUri}";
        // call logout endpoint
        $response = Http::get($requestUrl);
        // $response = Http::get('https://local-sys.auth.us-east-1.amazoncognito.com/logout?
        // client_id=29489jnimj6qsn84qsoku63unh&
        // logout_uri=http://localhost:8000');

 
        if ($response->successful()) {
          
            // return redirect($logoutRedirectUri);
            return redirect('http://localhost:8000/index');
        } else {
           
            return redirect()->back()->with('error', 'Logout failed. Please try again.');
        }
    }
}
