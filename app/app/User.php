<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'icon',
        'role',
        'del_flag'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    // ブックマークしている投稿を取得
    public function bookmarks()
    {
        return $this->belongsToMany(Post::class, 'bookmarks')->withTimestamps();
    }

    // 自分の「投稿」に対する違反報告（ユーザー違反数として扱う）
    public function postReports()
    {
        return $this->hasManyThrough(
            \App\Report::class,
            \App\Post::class, // through: Post
            'user_id',     // Post 外部キー -> users.id
            'post_id',     // Report 外部キー -> posts.id
            'id',          // users.id
            'id'           // posts.id
        );
    }

    public function scopeAlive($q)
    {
        return $q->where('del_flag', 0);
    }
    public function scopeStopped($q)
    {
        return $q->where('del_flag', 1);
    }


}
