<?php

namespace App\Console\Commands;

use App\Actions\CreateProductAction;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
    public function handle(CreateProductAction $action): void
    {
        $title = $this->argument('title');
        $user = $this->argument('user');

        if (! $title) {
            $title = $this->components->ask('Please, provide a valid title for the product');
        }

        if (! $user) {
            $user = $this->components->ask('Please, provide a valid user id');
        }

        Validator::make(['title' => $title, 'user' => $user], [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'user' => ['required', Rule::exists(User::class, 'id')],
        ])->validate();

        $action->handle($title, User::findOrFail($user));

        $this->components->info('Product created!!');
    }
}
