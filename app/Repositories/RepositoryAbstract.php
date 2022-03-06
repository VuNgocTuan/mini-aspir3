<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class RepositoryAbstract implements RepositoryInterface
{

	protected Model $model;

	/**
	 * Construct
	 *
	 * @return void
	 */
	public function __construct()
	{
	}

	public function all(): Collection
	{
		return $this->model->all();
	}

	public function with(array $withModel = [''])
	{
		return $this->model->with($withModel);
	}

	public function store(array $data)
	{
		$model = $this->model::create($data);
		
		return $model->fresh();
	}

	public function insert(array $data)
	{
		return $this->model::insert($data);
	}

	public function update(Model $model, array $data): bool
	{
		return $model->update($data);
	}

	public function delete(Model $model): bool
	{
		return $model->delete();
	}

	public function exist(mixed $id): bool
	{
		return !empty($this->find($id));
	}

	public function updateOrCreate(array $condition, array $data)
	{
		return $this->model->updateOrCreate($condition, $data);
	}

	public function findByField(mixed $field, mixed $value)
	{
		return $this->model->where($field, $value);
	}

	public function findByFields(array $conditions)
	{
		return $this->model->where($conditions);
	}

	public function find(mixed $id)
	{
		return $this->model->find($id);
	}

	public function findOrFail(mixed $id)
	{
		return $this->model->findOrFail($id);
	}

	public function firstOrCreate(array $data)
	{
		return $this->model->firstOrCreate($data);
	}

	public function upsert(array $data, array $keys, array $fields)
	{
		return $this->model->upsert($data, $keys, $fields);
	}
}
