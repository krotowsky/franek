<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\File;

class BunnyCDNStorageService
{
    private string $region = 'de';
    private string $baseHostname = 'storage.bunnycdn.com';
    private string $storageZoneName = 'test';
    private string $accessKey = 'ee058467-4199-4ea3-9879f77b9311-e62b-4b13';

    public function __construct(string $region, string $storageZoneName, string $accessKey)
    {
        $this->region = $region;
        $this->storageZoneName = $storageZoneName;
        $this->accessKey = $accessKey;
    }

    public function uploadFile(File $file, string $uploadPath): bool
    {


        $hostname = (!empty($this->region)) ? "{$this->region}.{$this->baseHostname}" : $this->baseHostname;
        $url = "https://storage.bunnycdn.com/test/";

        $ch = curl_init();
        $accessKey = 'ee058467-4199-4ea3-9879f77b9311-e62b-4b13';

        $options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_PUT => true,
            CURLOPT_INFILE => fopen($file->getRealPath(), 'r'),
            CURLOPT_INFILESIZE => filesize($file->getRealPath()),
            CURLOPT_HTTPHEADER => [
                "AccessKey: $accessKey",
                'Content-Type: application/octet-stream',
            ],
        ];

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);

        if (!$response) {
            return false;
        }

        curl_close($ch);

        return true;
    }
}