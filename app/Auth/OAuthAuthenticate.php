<?php


namespace App\Auth;


use GuzzleHttp\ClientInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OAuthAuthenticate
{

    protected $user;
    protected $token;
    protected $client;
    protected $uri = 'api/user/client';

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function attempt(Request $request): bool
    {
        $response = $this->requestUser($request);

        if($response)
        {
            return $this->storeUser($response);
        }

        return false;
    }

    public function clientId()
    {
        return $this->user()->clientId;
    }

    public function user()
    {
        return $this->user;
    }


    public function connection()
    {
        return $this->user->schema->name;
    }

    private function toJson($data)
    {
        return json_decode($data);
    }

    public function requestUser($request)
    {
        try{
            $response = $this->get(
                $this->validateUrl(),
                $this->withAuthorization($request->header('authorization'))
            );
            return $response;
        }catch (\Exception $exception)
        {
            return false;
        }
    }

    public function validateUrl()
    {
        return $this->baseUrl() . $this->uri;
    }

    protected function withAuthorization($token): array
    {
        return  [
            'headers' => [
                'Authorization' => $token,
            ]
        ];
    }

    public function baseUrl(): string
    {
        return env('API_GATEWAY_SERVER') ;
    }

    protected function get($url, $options = [])
    {
        return $this->client->get($url, $options);
    }

    public function storeUser($response): bool
    {
        $user = $this->toJson($response->getBody());
        $this->user = $user;
        return true;
    }

}
