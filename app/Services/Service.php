<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

abstract class Service implements ServiceInterface
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
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->getModelClass()::create($data);
    }

    /**
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data): bool
    {
        return $model->fill($data)->save();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->getModelClass()::destroy($id);
    }
}
