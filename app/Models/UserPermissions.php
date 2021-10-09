<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPermissions extends Model
{
    use HasFactory;
    protected $table = 'user_permissions';
    protected $primaryKey = 'NidPermission';
    public $incrementing = false;
    public    $timestamps = false;
    // protected $fillable = [];
    // protected $visible = [];
    // protected $hidden = [];
    public function user()
    {
        return $this->belongsTo(Users::class);
    }
    public function resource()
    {
        return $this->belongsTo(Resources::class);
    }
}
