<?php
namespace StatsAPI;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;

class StatsAPI
{
    protected $client;

    public function __construct()
    {
        $stack = function (Request $request) {
            $path = $request->getUri()->getPath();

            if (preg_match("/\/users\//", $path)) {
                if ($path === '/users/88224979-406e-4e32-9458-55836e4e1f95') {
                    return new Response(200, ['Content-Type' => 'application/json'], json_encode([
                        'id' => '88224979-406e-4e32-9458-55836e4e1f95',
                        'income' => 499999
                    ]));
                }
            }

            return new Response(404, ['Content-Type' => 'application/json'], json_encode([
                'code' => 100,
                'message' => 'Unexpected error'
            ]));
        };

        $this->client = new Client(['handler' => $stack]);
    }

    public function getGuzzleClient() : Client
    {
        return $this->client;
    }
}
