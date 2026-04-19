<?php

namespace App\Actions;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Native\Mobile\Facades\SecureStorage;

class HandshakeAction implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly string $email,
        private readonly string $password,
        public ?string          $endpoint = null,
    ) {
        if(!$this->endpoint) {
            $this->endpoint = config('mail.server_mail.auth_endpoint');
        }
    }

    /**
     * @throws ConnectionException
     */
    public function handle(): ?string
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])
            ->post($this->endpoint, [
                'email' => $this->email,
                'password' => $this->password,
            ]);

        if ($response->failed()) {
            Log::error('Handshake failed', [
                'endpoint' => $this->endpoint,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        }
        $token = $response->json('token');

        $encryptedToken = Crypt::encryptString($token);
        Cache::put(config()->string('auth.auth_token_ss_key'), $encryptedToken, now()->addHours(24));

        Log::info('Token arrived: '. $token);
        Log::info('Token saved: '. SecureStorage::get(config()->string('auth.auth_token_ss_key')));

        return $response->json('token');
    }
}
