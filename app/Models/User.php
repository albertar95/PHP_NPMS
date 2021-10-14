<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;
    protected $table = 'user';
    protected $primaryKey = 'NidUser';
    protected $fillable = ['UserName','Password','FirstName','LastName','ProfilePicture'];
    public $incrementing = false;
    public    $timestamps = false;
    // protected $visible = [];
    // protected $hidden = [];
    public function projects()
    {
        return $this->hasMany(Projects::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function userPermissions()
    {
        return $this->hasMany(UserPermissions::class);
    }
    public function role()
    {
        return $this->belongsTo(RolePermissions::class);
    }
}
