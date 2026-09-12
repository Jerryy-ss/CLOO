<?php

namespace App\Models;

use App\Services\FirestoreService;

class Officer
{
    public static string $collection = 'petugas';

    public static function findByLogin(string $login): ?array
    {
        $service = app(FirestoreService::class);

        $byEmail = $service->where(self::$collection, 'email', '=', strtolower(trim($login)));
        if ($byEmail) {
            return $byEmail[0];
        }

        $byUsername = $service->where(self::$collection, 'username', '=', trim($login));

        return $byUsername[0] ?? null;
    }

    public static function create(array $data): array
    {
        return app(FirestoreService::class)->create(self::$collection, $data, $data['id_petugas'] ?? null);
    }

    public static function all(): array
    {
        return app(FirestoreService::class)->all(self::$collection);
    }
}
