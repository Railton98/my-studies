<?php

namespace App\Models;

use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    /** @use HasFactory<\Database\Factories\VideoFactory> */
    use HasFactory;

    use Sluggable;

    protected string $slugCollumnFrom = 'name';

    protected $fillable = [
        'content_id',
        'code',
        'name',
        'thumb',
        'video',
        'is_processed',
        'slug',
    ];

    public function content(): BelongsTo
    {
        return $this->belongsTo(Content::class);
    }
}
