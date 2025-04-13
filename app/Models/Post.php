<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'body',
    ];

    /**
     * ブログポストのコメントを取得
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->chaperone();;
    }

    /**
     * 投稿の作成者を取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
