<?php

namespace App\Policies\Forum;

use Illuminate\Foundation\Auth\User;

use TeamTeaTime\Forum\Policies\ThreadPolicy as DefaultThreadPolicy;
use TeamTeaTime\Forum\Models\Thread;

class ThreadPolicy extends DefaultThreadPolicy
{
}
