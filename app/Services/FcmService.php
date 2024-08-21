<?php

namespace App\Services;

use Throwable;
use GuzzleHttp\Client;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Log;
use Psr\Http\Message\StreamInterface;
use GuzzleHttp\Exception\GuzzleException;

class FcmService
{
    private function fetchGoogleAccessToken():? string
    {
        try {
            $client = new GoogleClient();
            $client->setAuthConfig(storage_path('google/service-account.json'));
            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
            $client->refreshTokenWithAssertion();
            $token = $client->getAccessToken();
            return $token['access_token'];
        } catch (Throwable $e) {
            Log::error('Unable to fetch google access token', ['exception' => $e]);
        }

        return null;
    }

    /**
     * This method is being used to send payload to FCM
     *
     * @param array $payload
     * @return StreamInterface
     * @throws GuzzleException
     */
    public function request(array $payload): StreamInterface
    {
        $client = new Client();
        $accessToken = $this->fetchGoogleAccessToken();
        $response = $client->post('https://fcm.googleapis.com/v1/projects/chat-firebase-de134/messages:send', [
            'headers' => [
                'Authorization' => "Bearer $accessToken",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'message' => $payload
            ],
        ]);

        Log::debug('Send request to FCM', [
            'payload' => $payload,
            'response' => optional($response->getBody())->getContents(),
        ]);

        return $response->getBody();
    }
}
