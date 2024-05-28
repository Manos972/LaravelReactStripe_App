<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function creating(User $user)
    {
        $user->availaible_credits = 10;
    }

    public function decreaseCredits(User $user, $amount)
    {
        $user->availaible_credits -= $amount;
        $user->save();
    }
}
