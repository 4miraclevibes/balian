<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function uploadImage($image)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->post('https://uws.fsnthrds.com/api/image', [
            'multipart' => [
                ['name' => 'images', 'contents' => fopen($image->getPathname(), 'r'), 'filename' => $image->getClientOriginalName()]
            ]
        ]);
        
        $result = json_decode($response->getBody()->getContents());
        return $result->data->url;
    }
}
