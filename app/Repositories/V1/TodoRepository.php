<?php

namespace App\Repositories\V1;

use App\Models\Todo;
use App\Repositories\V1\Base\AbstractModelRepository;
use App\Repositories\V1\Interfaces\TodoRepositoryInterface;

class TodoRepository extends AbstractModelRepository implements TodoRepositoryInterface
{
    public function __construct()
    {
        $this->model = app()->make(Todo::class);
    }
}