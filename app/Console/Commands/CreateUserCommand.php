<?php

namespace App\Console\Commands;

use App\Models\User;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:super-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a super admin User';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fname = $this->ask('What is the FIrst name of the user?');
        $lname = $this->ask('What is the last name of the user?');
        $email = $this->ask('What is the email of the user?');
        $username = $this->ask('What is the username of the user?');
        $phone = $this->ask('What is the Phone of the user?');
        $password = $this->secret('What is the password for the user?');
        if (!Role::where('name', 'super_admin')->exists()) {
            $this->error("Role Super Admin does not exist.");
            return;
        }
        $user = User::create([
            'first_name' => $fname,
            'last_name' => $lname,
            'email' => $email,
            'username' => $username,
            'primary_phone' => $phone,
            'is_active' => true,
            'password' => Hash::make($password),
        ]);

        $role = Role::where('name', 'super_admin')->first();
        $user->assignRole($role);
        $this->info("User '{$fname}' created successfully and assigned the '{$role->name}' role.");
    }
}
