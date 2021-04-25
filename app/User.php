<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $guarded = ['id'];
    
    protected $hidden = [
        'password',
    ];


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permissions()
    {
        /* pluck return an array only with name attributes in this case */
        return $this->role->permissions->pluck('name');
    }

    
    public function hasAccess($access)
    {
        return $this->permissions()->contains($access);
    }
}
