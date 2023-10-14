<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function upVotes()
    {
        return $this->hasMany(Vote::class)->where('vote', 1);
    }

    public function downVotes()
    {
        return $this->hasMany(Vote::class)->where('vote', -1);
    }

    public function replies()
    {
        // self referencing relationship using parent_id
        return $this->hasMany(Thread::class, 'parent_id');
    }

    public function attachment(){
        return $this->morphOne(Fileable::class, 'fileable');
    }
}
