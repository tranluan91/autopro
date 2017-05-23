<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateMegaMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Mega menu';

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
        $li = '';
        foreach (\Config::get('convert.categories') as $category) {
            $li .= "<li><a href='/product-category/" . str_slug($category) . "'>$category</a></li>";
        }

        echo $li;
    }
}
