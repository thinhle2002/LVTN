<?php

namespace App\Repositories;

use Dotenv\Repository\RepositoryInterface;

abstract class BaseRepositories implements RepositoriesInterface
{
    protected $model;
    public function __construct()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    abstract public function getModel();

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        $object = $this->model->find($id);
        return $object->update($data);
    }

    public function delete($id)
    {
        $object = $this->model->find($id);
        return $object->delete();
    }
}
