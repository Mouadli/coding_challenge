<?php

namespace App\Console\Commands;

use App\Category;
use Illuminate\Console\Command;

class DeleteCategoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:delete {--id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete category by ID';

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
        Category::find($this->argument('id'))->delete();

        $this->info('Category successfully deleted');
    }
}
