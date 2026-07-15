<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\FriendRequest;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function sentRequests()
   {
    return $this->hasMany(FriendRequest::class, 'sender_id');
   }

    public function receivedRequests()
    {
    return $this->hasMany(FriendRequest::class, 'receiver_id');
    }

// pending requests of the users
    public function pendingRequests()
   {
    return $this->receivedRequests()->where('status', 'pending');
   }

// check if they are friends
    public function isFriendWith($userId)
   {
    return FriendRequest::where('status', 'accepted')
        ->where(function ($q) use ($userId) {
            $q->where('sender_id', auth()->id())->where('receiver_id', $userId);
        })
        ->orWhere(function ($q) use ($userId) {
            $q->where('sender_id', $userId)->where('receiver_id', auth()->id());
        })
        ->exists();
   }

// check if any pending request exists between two users
    public function hasSentRequestTo($userId)
    {
    return FriendRequest::where('sender_id', auth()->id())
        ->where('receiver_id', $userId)
        ->where('status', 'pending')
        ->exists();
    }
   public function savedPosts()
{
    return $this->hasMany(SavedPost::class);
}
}
