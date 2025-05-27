<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function uploadImage($image)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://uws.fsnthrds.com/api/service/store', [
            'multipart' => [
                [
                    'name' => 'files[]',
                    'contents' => fopen($image->getPathname(), 'r'),
                    'filename' => $image->getClientOriginalName()
                ]
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        // Jika $result['data'] adalah array, iterasi atau akses elemen yang tepat
        return $result['data'][0]['url'] ?? null; // Sesuaikan indeks sesuai kebutuhan
    }
}
