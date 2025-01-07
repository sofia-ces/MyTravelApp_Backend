<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;

class UserService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listUsers()
    {
        return $this->repository->getAll();
    }

    public function createUser(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return ['code' => 422,'errors' => $validator->errors()];
        }

        $data['password'] = bcrypt($data['password']);
        return $this->repository->create($data);
    }

    public function updateUser($id, array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return ['code' => 422,'errors' => $validator->errors()];
        }

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        return $this->repository->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->repository->delete($id);
    }
}
