<?php
namespace App\Repositories\V1\Interfaces\Base;

interface AbstractModelRepositoryInterface
{
    public function getList();
    public function getAll();
    public function getAllPaging();
    public function getWhere($field, $value);
    public function getWherePaging($field, $value);
    public function findById($id);
    public function findByIdWithTrashed($id);
    public function findWhere($field, $value);
    public function create($attributes = []);
    public function update($model, $attributes = []);
    public function delete($model);
    public function getSearchAll($limit = 10);
}
