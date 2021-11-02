<?php
namespace App\Repositories;

use App\Exceptions\ModelNotDefinedException;
use App\Repositories\Contracts\BaseRepositoryContract;
use Exception;

abstract class BaseRepository implements BaseRepositoryContract {
    public $model;

    public function __construct()
    {
        $this->model = $this->getModelClass();
        
    }

    protected function getModelClass(){
        if(!method_exists($this, 'model')){
            
            throw new ModelNotDefinedException();
        }

        return app()->make($this->model());
    }

    public function all(){
        return $this->model->all();
    }

    public function find($id){
        return $this->model->find($id);
    }

    public function findWhere($payload){
        return $this->model->where($payload)->get();
    }

    public function findWhereFirst($payload){
        return $this->model->where($payload)->first();
    }

    public function update($id, $payload){
        $record = $this->find($id);
        $record->update($payload);
        return $record;
    }

    public function create($payload){
        return $this->model->create($payload);
    }

}