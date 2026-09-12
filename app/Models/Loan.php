<?php

namespace App\Models;

use App\Services\FirestoreService;

class Loan
{
    public static string $collection = 'peminjaman';

    public static function find(string $id): ?array
    {
        return app(FirestoreService::class)->find(self::$collection, $id);
    }

    public static function all(): array
    {
        $items = app(FirestoreService::class)->all(self::$collection);
        usort($items, fn ($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));
        return $items;
    }

    public static function forMember(string $memberId): array
    {
        return app(FirestoreService::class)->where(self::$collection, 'id_anggota', '=', $memberId);
    }

    public static function activeForMemberBook(string $memberId, string $bookId): array
    {
        $items = self::forMember($memberId);

        return array_values(array_filter($items, function (array $loan) use ($bookId) {
            return ($loan['id_buku'] ?? null) === $bookId
                && in_array($loan['status'] ?? '', ['menunggu', 'disetujui', 'dipinjam'], true);
        }));
    }

    public static function create(array $data): array
    {
        return app(FirestoreService::class)->create(self::$collection, $data, $data['id_peminjaman'] ?? null);
    }

    public static function update(string $id, array $data): array
    {
        return app(FirestoreService::class)->update(self::$collection, $id, $data);
    }
}
