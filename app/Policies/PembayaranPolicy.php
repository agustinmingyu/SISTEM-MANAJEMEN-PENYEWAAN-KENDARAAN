<?php

namespace App\Policies;

use App\Models\Pembayaran;
use App\Models\User;

class PembayaranPolicy
{
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    public function view(User $user, Pembayaran $pembayaran)
    {
        return $user->isAdmin() || $user->id === $pembayaran->user_id;
    }

    public function update(User $user, Pembayaran $pembayaran)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Pembayaran $pembayaran)
    {
        return $user->isAdmin();
    }
}
