<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $table = 'roles';
    protected $primaryKey = 'NidRole';
    public $incrementing = false;
    public    $timestamps = false;
    protected $fillable = ['Title'];
    public function RolePermissions()
    {
        return $this->hasMany(RolePermissions::class);
    }
    public function Users()
    {
        return $this->hasMany(Users::class);
    }
}
