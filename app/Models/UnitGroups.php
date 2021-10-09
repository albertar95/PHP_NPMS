<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitGroups extends Model
{
    use HasFactory;
    protected $table = 'unit_groups';
    protected $primaryKey = 'NidGroup';
    public $incrementing = false;
    public    $timestamps = false;
    // protected $fillable = [];
    // protected $visible = [];
    // protected $hidden = [];
    public function projects()
    {
        return $this->hasMany(Projects::class);
    }
    public function unit()
    {
        return $this->belongsTo(Units::class);
    }
}
