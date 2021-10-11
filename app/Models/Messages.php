<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    use HasFactory;
    protected $table = 'messages';
    protected $primaryKey = 'NidMessage';
    public    $timestamps = false;
    // protected $fillable = [];
    // protected $visible = [];
    // protected $hidden = [];
    public function resources()
    {
        return $this->hasMany(Resources::class);
    }
    public function messages()
    {
        return $this->hasMany(Messages::class);
    }
    public function message()
    {
        return $this->belongsTo(Messages::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
