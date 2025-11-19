<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class CompanyRepository
{
    private string $file = 'data/companies.json';

    public function store(array $data): array
    {
        $companies = $this->all();
        $nextId = empty($companies) ? 1 : (max(array_column($companies, 'id')) + 1);
        $record = array_merge(['id' => $nextId], $data);
        $companies[] = $record;
        Storage::disk('local')->put($this->file, json_encode($companies, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $record;
    }

    public function all(): array
    {
        if (!Storage::disk('local')->exists($this->file)) {
            return [];
        }

        return json_decode(Storage::disk('local')->get($this->file), true) ?? [];
    }
}
