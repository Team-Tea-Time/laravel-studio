<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

#[Signature('app:create-user')]
#[Description('Create a new user')]
class CreateUser extends Command
{
    public function handle()
    {
        $password = $this->secret('Password');
        $confirm = $this->secret('Confirm password');

        if ($password != $confirm) {
            $this->error('Passwords do not match.');
            return self::FAILURE;
        }

        $data = [
            'name' => $this->ask('Name'),
            'email' => $this->ask('Email'),
            'password' => $password,
        ];

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return self::FAILURE;
        }

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $this->info("User created successfully!");
        $this->table(
            ['ID', 'Name', 'Email'],
            [[$user->id, $user->name, $user->email]]
        );

        return self::SUCCESS;
    }
}
