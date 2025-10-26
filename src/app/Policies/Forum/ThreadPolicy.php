<?php

namespace App\Policies\Forum;

use Illuminate\Foundation\Auth\User;

use TeamTeaTime\Forum\Policies\ThreadPolicy as DefaultThreadPolicy;
use TeamTeaTime\Forum\Models\Thread;

class ThreadPolicy extends DefaultThreadPolicy
{
    public function delete(User $user, Thread $thread): bool
    {
        return $user->getKey() === $thread->author_id || $user->id == 1;
    }

    public function restore(User $user, Thread $thread): bool
    {
        return $user->getKey() === $thread->author_id || $user->id == 1;
    }


    public function approvePosts(User $user, Thread $thread): bool
    {
        return $user->id == 1;
    }
}
