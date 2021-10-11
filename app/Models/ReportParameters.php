<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportParameters extends Model
{
    use HasFactory;
    protected $table = 'report_parameters';
    protected $primaryKey = 'NidParameter';
    public $incrementing = false;
    public    $timestamps = false;
    // protected $fillable = [];
    // protected $visible = [];
    // protected $hidden = [];
    public function report(){
        return $this->belongsTo(Reports::class);
    }
}
