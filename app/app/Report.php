<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['reporter_id', 'post_id', 'reason', 'status', 'del_flag'];

    // ▼ 追加：対象投稿
    public function post()
    {
        return $this->belongsTo(Post::class); // post_id
    }

    // ▼ 追加：通報者
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    // 表示用ラベル
    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 0: return '報告済';
            case 1: return '対応';
            default: return '不明';
        }
    }

    // del_flag=0
    public function scopeAlive($q)
    {
        return $q->where('del_flag', 0);
    }
}