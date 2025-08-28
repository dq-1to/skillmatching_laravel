<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobRequest extends Model
{
    protected $table = 'requests'; // テーブル名を明示
    protected $fillable = [
        'user_id',
        'post_id',
        'content',
        'tel',
        'email',
        'due_date',
        'del_flag'
        // statusは削除 - 受信者による更新のみ許可
    ];
    protected $casts = [
        'status' => 'integer',
        'del_flag' => 'boolean',
        'due_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // 依頼を受けた側 = posts.user_id
    public function scopeByRequester($q, $userId)
    {
        return $q->where('user_id', $userId);
    }

    // 依頼を受けた側 = posts.user_id
    public function scopeByRecipient($q, $userId)
    {
        // 依頼を受けた側 = posts.user_id
        return $q->whereHas('post', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    // 削除フラグが0のものを取得
    public function scopeAlive($q)
    {
        return $q->where('del_flag', 0);
    }

    // ステータス更新用のメソッド（受信者のみ使用）
    public function updateStatus($status)
    {
        $this->update(['status' => $status]);
    }
}


