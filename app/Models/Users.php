<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = ['NidUser'];
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
        return $this->hasMany(Users::class);
    }
    public function userPermissions()
    {
        return $this->hasMany(UserPermissions::class);
    }
}
