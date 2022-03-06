<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    public function all(): Collection;

    public function store(array $data);

    public function insert(array $data);

    public function upsert(array $data, array $keys, array $fields);

    public function update(Model $object, array $data): bool;

    public function delete(Model $model): bool;

    public function exist(mixed $id): bool;

    public function with(array $withModel = ['']);

    public function findByField(mixed $field, mixed $value);

    public function findByFields(array $conditions);

    public function find(mixed $id);

    public function findOrFail(mixed $id);

    public function firstOrCreate(array $data);

    public function updateOrCreate(array $condition, array $data);
}
