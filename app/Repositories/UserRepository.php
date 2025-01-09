<?php

namespace App\Repositories;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function createPersonalAccessToken(User $user): ?string
    {
        try {
            //$token = $user->createToken('MyApp')->plainTextToken;
          
            $token = $user->createToken('MyApp');
            $plainTextToken = $token->accessToken;
            return $plainTextToken;

        } catch (\Exception $e) {
            \Log::error("Error creating token: " . $e->getMessage());
            return null;
        }
    }
    
    public function getAll()
    {
        return User::all();
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function update($id, array $data)
    {
        $user = $this->findById($id);
        $user->update($data);

        return $user;
    }

    public function delete($id)
    {
        $user = $this->findById($id);
        return $user->delete();
    }
}
