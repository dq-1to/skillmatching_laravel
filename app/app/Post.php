<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{

    // フィルター
    protected $fillable = [
        'user_id',
        'title',
        'content', 
        'price',
        'image', 
        'del_flag', 
    ];

    // キャスト
    protected $casts = [
        'price'    => 'integer',
        'del_flag' => 'boolean', // tinyint(1)をboolとして扱う
    ];

    // ユーザーを取得
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ブックマークしているユーザーを取得
    public function bookmarkedBy()
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withTimestamps();
    }

    /** 検索スコープ */
    public function scopeTitleLike($query, $search)
    {
        return $search ? $query->where('title', 'like', "%{$search}%") : $query;
    }

    public function scopeFreeword($query, $search)
    {
        return $search
            ? $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%"); // ← body→content
            })
            : $query;
    }

    public function scopePriceMin($query, $value)
    {
        return is_numeric($value) ? $query->where('price', '>=', $value) : $query;
    }

    public function scopePriceMax($query, $value)
    {
        return is_numeric($value) ? $query->where('price', '<=', $value) : $query;
    }

    public function scopeByCategory($query, $category)
    {
        switch ($category) {
            case 'low':    return $query->where('price', '<=', 1000);
            case 'medium': return $query->whereBetween('price', [1001, 5000]);
            case 'high':   return $query->where('price', '>', 5000);
            default:       return $query;
        }
    }

    public function scopeOrderByPriority($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        if ($startDate) $query->where('created_at', '>=', $startDate);
        if ($endDate)   $query->where('created_at', '<=', $endDate);
        return $query;
    }

    // 自分の投稿を取得
    public function scopeMine($q, $userId) {
        return $q->where('user_id', $userId);
    }
}
