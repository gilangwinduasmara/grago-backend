<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function replies()
    {
        return $this->hasMany(Thread::class)->whereNull('parent_id');
    }

    public function startThread(array $data)
    {
        return $this->threads()->create($data);
    }

    public function replyThread(Thread $thread, array $reply)
    {
        $reply['parent_id'] = $thread->id;
        $reply['user_id'] = $this->id;
        return $thread->replies()->create($reply);
    }


    /**
     * @param Thread $thread
     * @param string $type up, down, or retract
     */
    public function voteThread(Thread $thread, $type){
        if(!in_array($type, ['up', 'down', 'retract'])){
            throw new \InvalidArgumentException('Invalid vote type');
        }

        if($type === 'retract'){
            return $thread->votes()->where('user_id', $this->id)->delete();
        }else {
            $thread->votes()->updateOrCreate([
                'user_id' => $this->id,
            ], [
                'value' => $type === 'up' ? 1 : -1,
            ]);
        }

        return $thread->refresh();
    }

    public function avatar(){
        return $this->morphOne(Fileable::class, 'fileable');
    }
}
