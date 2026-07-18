<?php

namespace App\Policies;

use App\Models\Kendaraan;
use App\Models\User;

class KendaraanPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Kendaraan $kendaraan)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, Kendaraan $kendaraan)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Kendaraan $kendaraan)
    {
        return $user->isAdmin();
    }
}
