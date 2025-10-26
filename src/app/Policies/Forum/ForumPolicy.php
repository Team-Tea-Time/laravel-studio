<?php

namespace App\Policies\Forum;

use Illuminate\Foundation\Auth\User;

use TeamTeaTime\Forum\Policies\ForumPolicy as DefaultForumPolicy;

class ForumPolicy extends DefaultForumPolicy
{
    public function approveThreads(User $user): bool
    {
        return $user->id == 1;
    }

    public function approvePosts(User $user): bool
    {
        return $user->id == 1;
    }
}
