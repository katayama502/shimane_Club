<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ClubRepository
{
    private string $file = 'data/clubs.json';

    public function all(): array
    {
        if (!Storage::disk('local')->exists($this->file)) {
            return [];
        }

        return json_decode(Storage::disk('local')->get($this->file), true) ?? [];
    }

    public function store(array $data): array
    {
        $clubs = $this->all();
        $nextId = empty($clubs) ? 1 : (max(array_column($clubs, 'id')) + 1);
        $record = [
            'id' => $nextId,
            'name' => $data['name'],
            'email' => $data['email'],
            'area' => $data['area'],
            'category' => $data['category'],
            'needs' => $data['needs'],
        ];
        $clubs[] = $record;
        Storage::disk('local')->put($this->file, json_encode($clubs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $record;
    }
}
