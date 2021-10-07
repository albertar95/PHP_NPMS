<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oreintations extends Model
{
    use HasFactory;
    protected $table = 'oreintations';
    protected $primaryKey = ['NidOreintation'];
    public $incrementing = false;
    // protected $fillable = [];
    // protected $visible = [];
    // protected $hidden = [];
    public function major()
    {
        return $this->belongsTo(Majors::class);
    }
    public function scholars()
    {
        return $this->hasMany(Scholars::class);
    }
}
