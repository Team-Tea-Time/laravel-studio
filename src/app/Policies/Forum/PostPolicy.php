<?php

namespace App\Policies\Forum;

use Illuminate\Foundation\Auth\User;
use TeamTeaTime\Forum\Models\Post;

use TeamTeaTime\Forum\Policies\PostPolicy as DefaultPostPolicy;

class PostPolicy extends DefaultPostPolicy
{
}
