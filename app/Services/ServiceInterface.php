<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

interface ServiceInterface
{
    public function create(array $data): Model;

    public function update(Model $model, array $data): bool;

    public function delete(int $id): bool;

}
