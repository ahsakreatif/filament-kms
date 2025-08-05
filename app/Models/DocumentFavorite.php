<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentFavorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'document_id',
        'user_id',
        'favorited_at',
    ];

    public $timestamps = false;

    protected $casts = [
        'favorited_at' => 'datetime',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
