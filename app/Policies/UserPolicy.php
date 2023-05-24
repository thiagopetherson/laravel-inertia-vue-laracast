<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->email !== 'paratodomundoconseguir@gmail.com';
    }

    public function edit(User $user)
    {
        return $user->email !== 'paratodomundoconseguir@gmail.com';
    }

    public function delete(User $user)
    {
        return $user->email !== 'paratodomundoconseguir@gmail.com';
    }
}
