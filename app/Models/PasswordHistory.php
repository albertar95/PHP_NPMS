<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordHistory extends Model
{
    use HasFactory;
    protected $table = 'password_histories';
    // protected $fillable = ['UserName','Password','FirstName','LastName','ProfilePicture'];
    public $incrementing = false;
    public    $timestamps = false;
}
