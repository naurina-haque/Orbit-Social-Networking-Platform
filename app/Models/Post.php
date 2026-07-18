<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content', 'image_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

     public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

     public function comments()
    {
    return $this->hasMany(Comment::class)->latest();
    }

    public function shares()
    {
        return $this->hasMany(Share::class);
    }

    public function isSharedBy($userId)
   {
    return $this->shares()->where('user_id', $userId)->exists();
   }

    public function isSavedBy($userId)
    {
        return $this->savedBy()->where('user_id', $userId)->exists();
    }

   public function savedBy()
{
    return $this->hasMany(SavedPost::class);
}
}
