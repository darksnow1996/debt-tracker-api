<?php
namespace App\Repositories\Contracts;

interface BaseRepositoryContract {

    public function all();

    public function find($id);

    public function findWhere(array $payload);

    public function findWhereFirst(array $payload);

    public function update($id, array $payload);

    public function create(array $payload);


}