<?php

namespace App\Filament\Admin;

use App\Actions\HandshakeAction;
use App\Models\User;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Native\Mobile\Facades\SecureStorage;

class CustomLogin extends BaseLogin
{
    /**
     * @throws ConnectionException
     */
    public function authenticate(): ?LoginResponse
    {
        $authentication = parent::authenticate();

        /** @var User $user */
        $user = auth()->user();

        Log::info($user);

        HandshakeAction::dispatch($user->email, $this->data['password']);

        return $authentication;
    }
}
