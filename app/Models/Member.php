<?php

namespace App\Models;

use App\Services\FirestoreService;

class Member
{
    public static string $collection = 'anggota';

    public static function find(string $id): ?array
    {
        return app(FirestoreService::class)->find(self::$collection, $id);
    }

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

    public static function existsByEmail(string $email): bool
    {
        return (bool) app(FirestoreService::class)
            ->where(self::$collection, 'email', '=', strtolower(trim($email)));
    }

    public static function existsByUsername(string $username): bool
    {
        return (bool) app(FirestoreService::class)
            ->where(self::$collection, 'username', '=', trim($username));
    }

    public static function create(array $data): array
    {
        return app(FirestoreService::class)->create(self::$collection, $data, $data['id_nama'] ?? null);
    }

    public static function all(): array
    {
        return app(FirestoreService::class)->all(self::$collection);
    }
}
