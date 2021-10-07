<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Units extends Model
{
    use HasFactory;
    protected $table = 'units';
    protected $primaryKey = 'NidUnit';
    public    $timestamps = false;
    public $incrementing = false;
    // protected $fillable = [];
        // protected $visible = [];
    // protected $hidden = [];
    public function unitGroups()
    {
        return $this->hasMany(UnitGroups::class);
    }
    public function projects()
    {
        return $this->hasMany(Projects::class);
    }
}
