<?php

namespace Visio\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Visio\Product\Enums\ImportanceLevel;

class Idea extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'importance',
        'context',
        'user_id',
        'reactions_count',
    ];

    protected $casts = [
        'importance' => ImportanceLevel::class,
        'reactions_count' => 'integer',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('product.ideas_table', 'ideas'));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('product.user_model', 'App\\Models\\User'));
    }

    public function comments(): HasMany
    {
        return $this->hasMany(IdeaComment::class)->orderBy('created_at', 'desc');
    }

    public function incrementReactions(): void
    {
        $this->increment('reactions_count');
    }

    public function decrementReactions(): void
    {
        $this->decrement('reactions_count');
    }
}
