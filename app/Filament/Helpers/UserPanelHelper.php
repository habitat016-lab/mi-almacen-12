<?php

namespace App\Filament\Helpers;

use App\Models\User;

class UserPanelHelper
{
    /**
     * Obtener nombre para mostrar en Filament
     */
    public static function getUserName($user): string
    {
        if (!$user instanceof User) {
            return 'Usuario';
        }

        $data = $user->getDisplayData();
        return $data['nombre'] ?? 'Usuario';
    }

    /**
     * Obtener email para mostrar en Filament
     */
    public static function getUserEmail($user): string
    {
        if (!$user instanceof User) {
            return '';
        }

        return $user->credencial->email ?? '';
    }

    /**
     * Obtener avatar para Filament
     */
    public static function getUserAvatar($user): ?string
    {
        if (!$user instanceof User) {
            return null;
        }

        $data = $user->getDisplayData();
        
        if ($data['foto']) {
            return asset('storage/fotos/' . $data['foto']);
        }

        return null;
    }
}
