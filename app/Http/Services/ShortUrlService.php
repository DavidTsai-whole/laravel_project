<?php
namespace App\Http\Services;

// 打別人的api
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ShortUrlService
{
    protected $client;
    public  $version = 2.5;
    public function __construct()
    {
        $this->client = new Client();
    }
    // line 35 report 會觸發Handler.php 的register
    //Log 可以用channel選擇你要存在哪 channel設定好後要去config裡的logging設定

    public function makeShortUrl($url)
    {
        try {
        $accesstoken = env('URL_ACCESS_TOKEN');
        $data = [
            'url' => $url
        ];
        Log::info('postData', ['data' => $data]);
        $response = $this->client->request(
            'POST',
            "https://api.pics.ee/v1/links/?access_token=$accesstoken",
            [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($data)
            ]
            );
            $contents = $response->getBody()->getContents();
            Log::channel('url_shorten')->info('responseData', ['data' => $contents]);
            $contents = json_decode($contents);
           // $contents['a']['123'];
        } catch (\Throwable $th) {
            report($th);
            return $url;
        }

            return $contents->data->picseeUrl;
    }
}