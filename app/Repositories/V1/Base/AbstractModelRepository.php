<?php

namespace App\Repositories\V1\Base;

use App\Repositories\V1\Interfaces\Base\AbstractModelRepositoryInterface;
use function request;


abstract class AbstractModelRepository implements AbstractModelRepositoryInterface
{
    protected $model;

    protected $perPage = 20;

    public function getDataTable()
    {

        $data = $this->model
            ->withSearch()
            ->withSort();
        $total = $data->count();

        $data = $data->withPaging()->get();

        return [
            'total' => $total,
            'rows' => $data
        ];
    }

    public function getList()
    {
        $request = request();
        if ($request->has('limit')) {
            $this->perPage = $request->limit;
            return $this->getAllPaging();
        }

        return $this->getAll();

    }

    public function getAll()
    {
        return $this->model->get();
    }

    public function getAllPaging()
    {
        return $this->model->latest()->paginate($this->perPage);
    }

    public function getWhere($field, $value)
    {
        return $this->model->where($field, $value)->get();
    }

    public function getWherePaging($field, $value)
    {
        return $this->model->where($field, $value)->paginate($this->perPage);
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function findByIdWithTrashed($id)
    {
        return $this->model->withTrashed()->findOrFail($id);
    }

    public function findWhere($field, $value)
    {
        return $this->model->where($field, $value)->firstOrFail();
    }

    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

    public function update($model, $attributes = [])
    {
        $model->fill($attributes);
        $model->save();

        return $model;
    }

    public function delete($model)
    {
        return $model->delete();
    }

    public function getSearchAll($limit = 10)
    {

        if ($limit > 0) {
            return $this->model->withsearch()->limit($limit)->get();
        }
        return $this->model->withsearch()->get();

    }

    public function firstOrCreate($condition = [], $additionInsertField = [])
    {
        return $this->model->firstOrCreate($condition, $additionInsertField);
    }
}
