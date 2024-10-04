<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;
    
     protected $fillable = [
      'user_id',
      'tweet',
    ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function liked()
  {
      return $this->belongsToMany(User::class)->withTimestamps();
  }

  public function comments()
  {
    return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
  }

  public function preserve()
{
    return $this->hasMany(Preserve::class);
}

public function preservedByUsers()
    {
        return $this->belongsToMany(User::class, 'preserves', 'tweet_id', 'user_id')->withTimestamps();
    }
    
    

    public function isPreservedBy($user)
    {
        return $this->preservedByUsers()->where('user_id', $user->id)->exists();
    }

}
