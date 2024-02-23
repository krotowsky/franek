<?php

declare(strict_types=1);

// src/Service/CloudflareStreamService.php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CloudflareStreamService
{
    private Client $client;
    private string $apiKey;
    private string $accountId;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = 'rAWLAL_TGbGhXliPwSbLokPLH86AD1Qzjm4-Vsi2';
        $this->accountId = 'dc08a0dc84f0249b31aac8c9638c6dcc';
    }

    public function uploadVideo(UploadedFile $video): ?string
    {
        $url = "https://api.cloudflare.com/client/v4/accounts/{$this->accountId}/stream";

        try {
            $response = $this->client->request('POST', $url, [
                'headers' => [
                    'Authorization' => "Bearer {$this->apiKey}",
                ],
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => fopen($video->getPathname(), 'r'),
                        'filename' => $video->getClientOriginalName(),
                    ],
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data['result']['uid'] ?? null;
        } catch (GuzzleException $e) {
            // Handle exception or log error
            return null;
        }
    }

}
