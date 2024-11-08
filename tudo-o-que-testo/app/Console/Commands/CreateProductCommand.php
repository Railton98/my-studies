<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-product-command {title?} {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new product';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $title = $this->argument('title');
        $user = $this->argument('user');

        if (! $title) {
            $title = $this->components->ask('Please, provide a valid title for the product');
        }

        if (! $user) {
            $user = $this->components->ask('Please, provide a valid user id');
        }

        Product::query()->create([
            'title' => $title,
            'owner_id' => $user,
        ]);

        $this->components->info('Product created!!');
    }
}
