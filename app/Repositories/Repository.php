<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract class Repository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     * @return string
     */
    abstract protected function getModelClass(): string;

    protected function startCondition(): Model
    {
        return clone $this->model;
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function getById(int $id): ?Model
    {
        return $this->startCondition()
            ->where('id', $id)
            ->first();
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function getByIdWithTrashed(int $id): ?Model
    {
        return $this->startCondition()
            ->withTrashed()
            ->where('id', $id)
            ->first();
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this->startCondition()
            ->all();
    }


}
