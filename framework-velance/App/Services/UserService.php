<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function get($id = null)
    {
        return $id ? User::select($id) : User::selectAll();
    }

    public function post(array $data)
    {
        return User::insert($data);
    }

    public function update($id, array $data) {}

    public function delete(int $id)
    {
        return User::delete($id);
    }
}
