<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user {email} {password} {role?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');
        $role = $this->argument('role');
        $name = explode('@', $email)[0];
        $user = new User();
        $user->email = $email;
        $user->name = $name;
        $user->password = bcrypt($password);
        $user->role = ($role) ? User::ADMIN : User::USER;
        $user->save();
    }
}
