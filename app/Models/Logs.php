<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;
    protected $table = 'logs';
    protected $primaryKey = 'NidLog';
    public $incrementing = false;
    public    $timestamps = false;
    // protected $fillable = [];
    // protected $visible = [];
    // protected $hidden = [];
    public function actionTypes()
    {
        return $this->belongsTo(LogActionTypes::class);
    }
}
