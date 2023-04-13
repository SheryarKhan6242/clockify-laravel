<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:super-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new super admin user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Enter the name of the super admin user');
        $email = $this->ask('Enter the email of the super admin user');
        $password = $this->secret('Enter the password of the super admin user');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => true,
        ]);

        $this->info('Super admin user created successfully!');

        return 0;
    }
}
