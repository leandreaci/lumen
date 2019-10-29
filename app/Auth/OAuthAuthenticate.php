<?php


namespace App\Auth;


use Illuminate\Http\Request;

class OAuthAuthenticate
{

    public function attempt(Request $request): bool
    {
        return $this->send($request);
    }

    private function send(Request $request): bool
    {

        $client = new \GuzzleHttp\Client();
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
