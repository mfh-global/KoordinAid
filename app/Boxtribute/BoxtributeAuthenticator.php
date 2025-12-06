<?php

namespace App\Boxtribute;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class BoxtributeAuthenticator
{
    private string $boxtributeEndpoint;
    private string $boxtributePassword;
    private string $boxtributeUser;
    private ?string $boxtributeToken = null;
    private const BOXTRIBUTE_ACCESS_FILE = 'boxtribute_access';

    public function __construct()
    {
        $this->boxtributeEndpoint = config('boxtribute.api_endpoint') ?? '';
        $this->boxtributePassword = config('boxtribute.password') ?? '';
        $this->boxtributeUser = config('boxtribute.user') ?? '';
    }
   
    public function getAuth(): array
    {
        if ($this->boxtributeToken === null) {
            $this->boxtributeToken = $this->getToken();
        }
        return ['Authorization' => "Bearer {$this->boxtributeToken}"];
    }

    private function getToken(): string
    {
        if (Storage::exists(self::BOXTRIBUTE_ACCESS_FILE)) {
            $access = json_decode(Storage::get(self::BOXTRIBUTE_ACCESS_FILE), true);
            if (!$this->needNewToken($access['created'], $access['expires_in'])) {
                return $access['access_token'];
            }
        }

        $requestData = ['username' => $this->boxtributeUser, 'password' => $this->boxtributePassword];
        $response = Http::post($this->boxtributeEndpoint . '/token', $requestData);

        if ($response->status() !== 200) {
            throw new \RuntimeException("failed to get boxtribute authorization, status: {$response->status()}, body: {$response->body()}");
        }

        $body = $response->json();
        $boxtributeAccess = [
            ...$body,
            'created' => time()
        ];

        Storage::put(self::BOXTRIBUTE_ACCESS_FILE, json_encode($boxtributeAccess));

        return $boxtributeAccess['access_token'];
    }

    private function needNewToken(int $created, int $expiresIn): bool
    {
        return time() - $created > $expiresIn - 28000;
    }
}
