<?php

namespace App\Console\Commands;

use App\Admin;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin';

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
        $user = Admin::create([
            'name' => 'Vladimir',
            'role' => 'admin',
            'email' => 'admin@mail.ru',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('root'),
            'remember_token' => Str::random(10),
        ]);
        $user->save();
    }
}
