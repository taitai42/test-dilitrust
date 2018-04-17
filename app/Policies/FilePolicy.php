<?php

namespace App\Policies;

use App\File;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    public function view(User $user, File $file): bool
    {
        // a user can see the file if he is the owner, if the file is public, or if he has been
        // authorized by the owner.
        return $this->is_owner($user, $file) || $file->public
            || $file->viewers()->where([
                ['user_id', $user->id],
                ['can_see', true], // make sure can_see is set to true in case we want to implement acl features
            ])->count() > 0;
    }

    private function is_owner(User $user, File $file): bool
    {
        return $file->user_id === $user->id;
    }

    public function delete(User $user, File $file): bool
    {
        return $this->is_owner($user, $file);
    }
}
