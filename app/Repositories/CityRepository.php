<?php

namespace App\Repositories;

use App\Models\Cities;

class CityRepository extends Repository
{
    protected function getModelClass(): string
    {
        return Cities::class;
    }
}
