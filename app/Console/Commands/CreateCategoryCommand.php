<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Category;

class CreateCategoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'category:create {name} {categoryParent?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new category';

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
        Category::create([
            'name'=>$this->argument('name'),
            'parent_id' =>$this->argument('categoryParent') ?? null
        ]);

        $this->info('Successfully created.');
    }
}
