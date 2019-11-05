<?php


namespace App\Auth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class OAuthAuthenticate
{

    public function attempt(Request $request): bool
    {
        return $this->send($request) ;
    }

    public function connection()
    {
        return $this->user()->schema->name;
    }

    public function user()
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->get(env('AUTH_SERVER') . '/api/user/client',  [
            'headers' => [
                'Authorization' => Cache::get('TOKEN'),
            ]
        ] );

        return json_decode($response->getBody());
    }

    private function send(Request $request): bool
    {

        $client = new \GuzzleHttp\Client();

        Cache::store('file')->put('TOKEN', $request->header('authorization'));

        $url = env( 'AUTH_SERVER');

        try
        {
            $response = $client->get($url, [
                'headers' => [
                    'Authorization' => $request->header('authorization'),
                ]
            ]);

            return $response->getStatusCode() == 200;
        }catch (\Exception $exception)
        {
            return false;
        }
    }

}
