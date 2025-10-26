<?php

namespace App\Policies\Forum;

use Illuminate\Foundation\Auth\User;

use TeamTeaTime\Forum\Policies\CategoryPolicy as DefaultCategoryPolicy;
use TeamTeaTime\Forum\Models\Category;

class CategoryPolicy extends DefaultCategoryPolicy
{
    public function createThreadsWithoutApproval(User $user, Category $category): bool
    {
        return $user->id == 1;
    }

    public function approveThreads(User $user, Category $category): bool
    {
        return $user->id == 1;
    }
}
