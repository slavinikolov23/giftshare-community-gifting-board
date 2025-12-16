<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    public const STATUS_AVAILABLE = 'available';
    public const STATUS_GIFTED = 'gifted';

    protected $fillable = [
        'title',
        'description',
        'city',
        'weight',
        'dimensions',
        'status',
        'user_id',
        'category_id',
    ];

    protected $casts = [
        'weight' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function getVotesScoreAttribute(): int
    {
        return $this->votes()->sum('value');
    }

    public function isGifted(): bool
    {
        return $this->status === self::STATUS_GIFTED;
    }
}
