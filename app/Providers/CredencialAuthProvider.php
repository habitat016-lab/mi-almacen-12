<?php

namespace App\Providers;

use App\Models\AsignacionCredencial;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class CredencialAuthProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        return AsignacionCredencial::find($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        return null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // No usado
    }

    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)) {
            return null;
        }

        return AsignacionCredencial::where('correo_electronico', 
$credentials['correo'])->first();
    }

    public function validateCredentials(Authenticatable $user, array 
$credentials)
    {
        return \Hash::check($credentials['password'], 
$user->getAuthPassword());
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array 
$credentials, bool $force = false)
    {
        // No necesitamos rehash en este caso
        return false;
    }
}
