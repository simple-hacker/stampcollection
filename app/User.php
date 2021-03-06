<?php

namespace App;

use App\Stamp;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Returns a collection of the user's stamps.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function collection()
    {
        // I think this just needs to be a raw
        return $this->hasMany('App\Collection')
                    ->with(['stamp', 'grading'])
                    ->orderBy('stamp_id', 'asc')
                    ->orderBy('grading_id', 'asc');
    }

    /**
     * Returns a collection of the user's stamps.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function stamps()
    {
        return $this->belongsToMany('App\Stamp', 'collections')->withTimestamps();
    }
}
