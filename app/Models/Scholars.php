<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholars extends Model
{
    use HasFactory;
    protected $table = 'scholars';
    protected $primaryKey = ['NidScholar'];
    protected $fillable = ['ProfilePicture','FirstName','LastName','NationalCode','BirthDate','Mobile','MillitaryStatus','GradeId','MajorId','OreintationId','college','CollaborationType'];
    public $incrementing = false;
    public    $timestamps = false;
    // protected $visible = [];
    // protected $hidden = [];
    public function projects()
    {
        return $this->hasMany(Projects::class);
    }
    public function major()
    {
        return $this->belongsTo(Majors::class);
    }
    public function orientation()
    {
        return $this->belongsTo(Oreintations::class);
    }
}
