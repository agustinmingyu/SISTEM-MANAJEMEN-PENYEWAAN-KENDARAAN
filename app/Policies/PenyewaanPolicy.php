<?php

namespace App\Policies;

use App\Models\Penyewaan;
use App\Models\User;

class PenyewaanPolicy
{
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    public function view(User $user, Penyewaan $penyewaan)
    {
        return $user->isAdmin() || $user->id === $penyewaan->user_id;
    }

    public function create(User $user)
    {
        return $user->isUser() || $user->isAdmin();
    }

    public function update(User $user, Penyewaan $penyewaan)
    {
        if ($user->isAdmin()) return true;
        return $user->id === $penyewaan->user_id && $penyewaan->status === 'Pending';
    }

    public function delete(User $user, Penyewaan $penyewaan)
    {
        if ($user->isAdmin()) return true;
        return $user->id === $penyewaan->user_id && $penyewaan->status === 'Pending';
    }
}
