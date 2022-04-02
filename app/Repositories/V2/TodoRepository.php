<?php

namespace App\Repositories\V2;

use App\Models\Todo;
use App\Repositories\V2\Base\AbstractModelRepository;
use App\Repositories\V2\Interfaces\TodoRepositoryInterface;

class TodoRepository extends AbstractModelRepository implements TodoRepositoryInterface
{
    public function __construct()
    {
        $this->model = app()->make(Todo::class);
    }
}