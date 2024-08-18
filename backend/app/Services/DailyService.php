<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DailyService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.daily.co/v1/',
            'headers'  => [
                'Authorization' => 'Bearer ' . env('DAILY_API_KEY'),
                'Content-Type'  => 'application/json',
            ],
        ]);
        $this->apiKey = env('DAILY_API_KEY');
    }

    public function createRoom($name)
    {
        try {
            $response = $this->client->post('rooms', [
                'json' => [
                    'name' => $name,
                    'properties' => [
                        'enable_chat' => true,
                        'enable_recording' => false,
                    ]
                ]
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            // Log the error or handle it as needed
            return ['error' => $e->getMessage()];
        }
    }

    public function deleteRoom($name)
    {
        try {
            $response = $this->client->delete('rooms/' . $name);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}