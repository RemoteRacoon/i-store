<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $http = new Client();

        try {
            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->username,
                    'password' => $request->password,
                ]
            ]);
            $body = json_decode($response->getBody());
            $token = $body->access_token;
            $expires_in = $body->expires_in;
            $refresh_token = $body->refresh_token;
            $user = json_decode($http->get(config('services.passport.user_endpoint'),[
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ]
            ])->getBody()->getContents());

            return response()->json(compact('user','token', 'refresh_token', 'expires_in'));

        } catch (BadResponseException $e) {
            if ($e->getCode() === 400) {
                return response()->json('Invalid Request. Please enter a username or a password.', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }
        }
        return response()->json('Something wrong happened on the server side', $e->getCode());

    }

    public function refreshToken(Request $request) {
        $http = new Client;
        $response = $http->post(config('services.passport.login_endpoint'), [
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $request->refresh_token,
                'client_id' => config('services.passport.client_id'),
                'client_secret' => config('services.passport.client_secret'),
            ]
        ]);

        $body = json_decode($response->getBody());
        $token = $body->access_token;
        $expires_in = $body->expires_in;
        $refresh_token = $body->refresh_token;
        $user = json_decode($http->get(config('services.passport.user_endpoint'), [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ]
        ])->getBody()->getContents());
        return response()->json(
            compact('token', 'expires_in', 'refresh_token', 'user'),
            200
        );
    }

    public function logout() {
        auth()->user()->tokens->each(function($token, $key){
            $token->delete();
        });
        return response()->json('Logged out successfully', 200);
    }
}
