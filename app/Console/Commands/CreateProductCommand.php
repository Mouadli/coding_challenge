<?php

namespace App\Console\Commands;

use App\Product;
use Illuminate\Console\Command;

class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create {--name=} {--description=} {--price=} {--category_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new product';

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
        Product::create([
            'name'=> $this->option('name'),
            'description'=> $this->option('description'),
            'price'=> $this->option('price'),
            'category_id'=>$this->option('category_id')
        ]);

        $this->info('Successfully created.');
    }
}
