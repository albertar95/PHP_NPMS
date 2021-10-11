<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\returnSelf;

class Majors extends Model
{
    use HasFactory;
    protected $table = 'majors';
    protected $primaryKey = 'NidMajor';
    protected $fillable = ['Title'];
    public $incrementing = false;
    public    $timestamps = false;
    // protected $visible = [];
    // protected $hidden = [];
    public function oreintations()
    {
        return $this->hasMany(Oreintations::class);
    }
    public function scholars()
    {
        return $this->hasMany(scholars::class);
    }
}
