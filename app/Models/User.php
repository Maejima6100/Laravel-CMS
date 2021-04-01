<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Models\Post;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'avatar',
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
    
    public function setPasswordAttribute($value){
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function nestedcomments() {
        return $this->hasMany(Nestedcomment::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function userHasLiked(Post $post){
        if(count($post->likes) > 0){
            foreach($post->likes as $like){  
            if($this->id == $like->user->id) return true;
            }
        }
        return false;
    }       

    public function userHasRole($role_name){
        foreach($this->roles as $role){
            if(strtolower($role_name) == strtolower($role->name)){
            return true;
            }
        }
        return false;
    }

    public function getAvatarAttribute($value) {
        if (strpos($value, 'https://') !== FALSE || strpos($value, 'http://') !== FALSE) {
            return $value;
        }
        return asset('storage/' . $value);
        }


}
