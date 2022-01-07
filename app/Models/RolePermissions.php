<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermissions extends Model
{
    use HasFactory;
    protected $table = 'role_permissions';
    protected $primaryKey = 'NidPermission';
    public $incrementing = false;
    public    $timestamps = false;
    protected $fillable = ['RoleId','EntityId','Create','Edit','Delete','Detail','Confident','List','Print'];
    // protected $visible = [];
    // protected $hidden = [];
    public function role()
    {
        return $this->belongsTo(RolePermissions::class);
    }
}
