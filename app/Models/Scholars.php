<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Scholars extends Model
{
    use HasFactory;
    protected $table = 'scholars';
    protected $primaryKey = 'NidScholar';
    protected $fillable = ['ProfilePicture','FirstName','LastName','NationalCode','BirthDate','Mobile','MillitaryStatus','GradeId','MajorId','OreintationId','college','CollaborationType','IsDeleted'];
    public $incrementing = false;
    public    $timestamps = false;
    // protected $visible = [];
    // protected $hidden = [];
    public function projects()
    {
        return $this->hasMany(Projects::class,'ScholarId','NidScholar');
    }
    public function major()
    {
        return $this->belongsTo(Majors::class,'MajorId','NidMajor');
    }
    public function orientation()
    {
        return $this->belongsTo(Oreintations::class,'OreintationId','NidOreintation');
    }
}
