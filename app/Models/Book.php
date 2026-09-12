<?php

namespace App\Models;

use App\Services\FirestoreService;

class Book
{
    public static string $collection = 'buku';

    public static function all(?string $search = null): array
    {
        $books = app(FirestoreService::class)->all(self::$collection);

        if ($search) {
            $search = mb_strtolower($search);

            $books = array_values(array_filter($books, function (array $book) use ($search) {
                $haystack = mb_strtolower(implode(' ', [
                    $book['nama_buku'] ?? '',
                    $book['penulis'] ?? '',
                    $book['kategori'] ?? '',
                ]));

                return str_contains($haystack, $search);
            }));
        }

        usort($books, fn ($a, $b) => strcmp($b['created_at'] ?? '', $a['created_at'] ?? ''));

        return $books;
    }

    public static function find(string $id): ?array
    {
        return app(FirestoreService::class)->find(self::$collection, $id);
    }

    public static function create(array $data): array
    {
        return app(FirestoreService::class)->create(self::$collection, $data, $data['id_buku'] ?? null);
    }

    public static function update(string $id, array $data): array
    {
        return app(FirestoreService::class)->update(self::$collection, $id, $data);
    }

    public static function delete(string $id): void
    {
        app(FirestoreService::class)->delete(self::$collection, $id);
    }

    public static function count(): int
    {
        return count(app(FirestoreService::class)->all(self::$collection));
    }
}
