<?php

namespace App\Domains\Eloquent;

use App\Domains\Eloquent\IEloquentRepository;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements IEloquentRepository
{

     protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
