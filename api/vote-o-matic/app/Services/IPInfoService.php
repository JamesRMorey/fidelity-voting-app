<?php

namespace App\Services;

use App\Classes\IPLocation;
use GuzzleHttp\Client;

class IPInfoService
{
    protected string $baseUrl;
    protected string $token;
    protected Client $client;

    public function __construct()
    {
        $this->baseUrl = config('ipInfo.base_url');
        $this->token = config('ipInfo.token');
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
            ]
        ]);
    }

    public function getIPLocation( string $ipAddress ): ?IPLocation
    {
        try {
            $response = $this->client->get( '/' . $ipAddress );

            $data = json_decode( $response->getBody()->getContents() );

            return new IPLocation(
                city: $data->city ?? null,
                region: $data->region ?? null,
                country: $data->country ?? null,
                loc: $data->loc ?? null,
                postal: $data->postal ?? null,
                timezone: $data->timezone ?? null
            );
        } catch (\Exception $e) {
            return null;
        }
    }
}
