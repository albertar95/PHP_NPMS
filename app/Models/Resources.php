<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    use HasFactory;
    protected $table = 'resources';
    protected $primaryKey = 'NidResource';
    public $incrementing = false;
    public    $timestamps = false;
    // protected $fillable = [];
    // protected $visible = [];
    // protected $hidden = [];
    public function resource()
    {
        return $this->belongsTo(Resources::class);
    }
    public function resources()
    {
        return $this->hasMany(Resources::class);
    }
    public function userPermissions()
    {
        return $this->hasMany(UserPermissions::class);
    }
}
