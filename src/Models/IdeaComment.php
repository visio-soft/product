<?php

namespace Visio\Product\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class IdeaComment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'idea_id',
        'user_id',
        'comment',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('product.comments_table', 'idea_comments'));
    }

    public function idea(): BelongsTo
    {
        return $this->belongsTo(Idea::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(config('product.user_model', 'App\\Models\\User'));
    }
}
