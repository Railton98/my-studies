<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly array $data,
        public readonly int $ownerId,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->data as $item) {
            Product::query()->create([
                'title' => $item['title'],
                'owner_id' => $this->ownerId,
            ]);
        }
    }
}
