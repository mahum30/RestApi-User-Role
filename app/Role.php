<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;


class Role extends Model implements JWTSubject
{
    use Notifiable;

    protected $table = 'roles';
    protected $fillable = ['name', 'description'];

    public function getJWTIdentifier()
    {
         return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
