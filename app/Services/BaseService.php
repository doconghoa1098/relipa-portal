<?php

namespace App\Services;

abstract class BaseService
{
    protected $model;

    public function __construct()
    {

        return $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function get()
    {

        return $this->model->latest()->get();
    }

    public function findOrFail($id)
    {

        return $this->model->findOrFail($id);

    }

    public function store($values = [])
    {
        $this->model->fill($values);

        return $this->model->save();
    }

    public function update($id, $value)
    {
        $this->findOrFail($id);
        $this->model->fill($value);

        return $this->model->save();
    }

    public function delete($id)
    {
        $this->findOrFail($id);

        return $this->model->delete();
    }
}
