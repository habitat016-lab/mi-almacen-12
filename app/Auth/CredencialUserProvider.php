<?php

namespace App\Auth;

use App\Models\AsignacionCredencial;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class CredencialUserProvider implements UserProvider
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
        // No necesario
    }

    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)) {
            return null;
        }

        return AsignacionCredencial::where('correo_electronico', 
$credentials['email'])->first();
    }

    public function validateCredentials(Authenticatable $user, array 
$credentials)
    {
        return password_verify($credentials['password'], 
$user->getAuthPassword());
    }
}
