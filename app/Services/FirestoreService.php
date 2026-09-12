<?php

namespace App\Services;

use Kreait\Laravel\Firebase\Facades\Firebase;

class FirestoreService
{
    public function database()
    {
        return Firebase::firestore()->database();
    }

    public function collection(string $name)
    {
        return $this->database()->collection($name);
    }

    public function find(string $collection, string $id): ?array
    {
        $document = $this->collection($collection)->document($id)->snapshot();

        if (! $document->exists()) {
            return null;
        }

        return array_merge(
            ['_id' => $document->id()],
            $document->data()
        );
    }

    public function all(string $collection): array
    {
        $items = [];

        foreach ($this->collection($collection)->documents() as $document) {
            if ($document->exists()) {
                $items[] = array_merge(
                    ['_id' => $document->id()],
                    $document->data()
                );
            }
        }

        return $items;
    }

    public function create(string $collection, array $data, ?string $id = null): array
    {
        $id ??= (string) \Illuminate\Support\Str::uuid();

        $data['created_at'] ??= now()->toIso8601String();
        $data['updated_at'] ??= now()->toIso8601String();

        $this->collection($collection)->document($id)->set($data);

        return array_merge(['_id' => $id], $data);
    }

    public function update(string $collection, string $id, array $data): array
    {
        $data['updated_at'] = now()->toIso8601String();

        $this->collection($collection)->document($id)->set($data, ['merge' => true]);

        return $this->find($collection, $id) ?? array_merge(['_id' => $id], $data);
    }

    public function delete(string $collection, string $id): void
    {
        $this->collection($collection)->document($id)->delete();
    }

    public function where(string $collection, string $field, string $operator, mixed $value): array
    {
        $query = $this->collection($collection)->where($field, $operator, $value);
        $items = [];

        foreach ($query->documents() as $document) {
            if ($document->exists()) {
                $items[] = array_merge(
                    ['_id' => $document->id()],
                    $document->data()
                );
            }
        }

        return $items;
    }
}
