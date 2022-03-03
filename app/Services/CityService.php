<?php

namespace App\Services;

use App\Models\Cities;

class CityService extends Service
{
    protected function getModelClass(): string
    {
        return Cities::class;
    }
}
