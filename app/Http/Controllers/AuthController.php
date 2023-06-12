<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Customer;
use Illuminate\Support\Str;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Response;

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
        if (env('APP_ENV') == 'local') {
            $loginUrl = env('COGNITO_LOGIN_URL');
            return redirect($loginUrl);
        } else {
            return redirect()->route('handleALBCallback');
        }
    }

    public function handleCognitoCallback(Request $request)
    {
        try {
            $code = $request->query('code');

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
                        'name' => $userName,
                        'email' => $userEmail,
                        'cognito_id' => $cognitoId,
                    ]);
                } elseif (isset($customer) && $customer->cognito_id == null) {
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
        $encodedJwt = $request->header('x-amzn-oidc-data');

        // Step 1: Get the key ID from JWT headers (the kid field)
        $jwtHeaders = explode('.', $encodedJwt)[0];
        $decodedJwtHeaders = base64_decode($jwtHeaders);
        $decodedJson = json_decode($decodedJwtHeaders, true);
        $kid = $decodedJson['kid'];

        // Step 2: Get the public key from the regional endpoint
        $region = 'us-east-1';
        $url = "https://public-keys.auth.elb.$region.amazonaws.com/$kid";
        $response = Http::get($url);
        $pubKey = $response->body();

        //step3
        $algorithms = 'ES256';
        $payload = JWT::decode($encodedJwt, new Key($pubKey, $algorithms));
        // dump($payload);
        $userName = $payload->name;
        $cognitoId = $payload->sub;
        $userEmail = $payload->email;

        //cognito ID
        $customer = Customer::where('email', $userEmail)->first();

        if (!$customer) {
            // Customer does not exist, create a new record
            $customer = Customer::create([
                'name' => $userName,
                'email' => $userEmail,
                'cognito_id' => $cognitoId,
            ]);
        } elseif (isset($customer) && $customer->cognito_id == null) {
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
    }

     public function logout(Request $request)
    {
        //config Logout endpoint
        $request->session()->invalidate();
        $clientId = env('COGNITO_CLIENT_ID');
        $logoutUrl = env('COGNITO_LOGOUT_URL');
        $logoutRedirectUri = env('COGNITO_LOGOUT_REDIRECT_URI');
        $requestUrl = "{$logoutUrl}?client_id={$clientId}&logout_uri={$logoutRedirectUri}";
       
            // Delete ALB cookies
          $response = new Response();
$response = $response->withCookie(Cookie::make('AWSELBAuthSessionCookie-0', null, -1));
$response = $response->withCookie(Cookie::make('AWSELBAuthSessionCookie-1', null, -1));
$response = $response->withCookie(Cookie::make('AWSALBAuthNonce', null, -1));

// Add cache control headers
$response = $response->header('Cache-Control', 'no-store, no-cache, must-revalidate');
$response = $response->header('Pragma', 'no-cache');
$response = $response->header('Expires', '0');

// Call logout endpoint
$response->setStatusCode(302);
$response->header('Location', $requestUrl);
return $response;

        
    }
}
