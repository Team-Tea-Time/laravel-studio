<?php

namespace App\Policies\Forum;

use Illuminate\Foundation\Auth\User;

use TeamTeaTime\Forum\Policies\CategoryPolicy as DefaultCategoryPolicy;
use TeamTeaTime\Forum\Models\Category;

class CategoryPolicy extends DefaultCategoryPolicy
{
}
