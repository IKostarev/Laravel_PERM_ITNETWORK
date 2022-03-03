<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    // Вариант 1
    //protected $signature = 'user:new {--name=} {--email=} {--password=}';

    // Вариант 2
    //protected $signature = 'user:new {--params*}';

    // Вариант 3
    protected $signature = 'user:new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Команда создания пользователя';

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
     * @return int
     */
    public function handle()
    {
        // Вариант 1
        /*User::create([
            'name' => $this->option('name'),
            'email' => $this->option('email'),
            'password' => \Hash::make($this->option('password')),
        ]);*/

        // Вариант 2
        /*$params = $this->argument('params');
        User::create([
            'name' => $params[0],
            'email' => $params[1],
            'password' => \Hash::make($params[2]),
        ]);*/

        // Вариант 3
        $data = [
            'name' => $this->ask('Введите имя пользователя'),
            'email' => $this->ask('Введите email пользователя')
        ];

        $originPassword = $this->secret('Введите пароль пользователя');

        $data['password'] = \Hash::make($originPassword);

        User::create($data);

        $this->info('Пользователь успешно создан.');
        $this->info('Email: ' . $data['email']);
        $this->info('Пароль: ' . $originPassword);

        return 0;
    }
}
