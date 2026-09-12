<?php

namespace App\Models;

use App\Services\FirestoreService;

class Fine
{
    public static string $collection = 'denda';

    public static function forLoan(string $loanId): ?array
    {
        $items = app(FirestoreService::class)->where(self::$collection, 'id_peminjaman', '=', $loanId);
        return $items[0] ?? null;
    }

    public static function create(array $data): array
    {
        return app(FirestoreService::class)->create(self::$collection, $data, $data['id_denda'] ?? null);
    }

    public static function update(string $id, array $data): array
    {
        return app(FirestoreService::class)->update(self::$collection, $id, $data);
    }

    public static function all(): array
    {
        return app(FirestoreService::class)->all(self::$collection);
    }
}
