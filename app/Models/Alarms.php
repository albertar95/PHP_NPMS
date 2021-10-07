<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alarms extends Model
{
    use HasFactory;
    protected $table = 'alarms';
    protected $primaryKey = ['NidMaster','AlarmSubject'];
    public $incrementing = false;
    // protected $fillable = [];
    // protected $visible = [];
    // protected $hidden = [];
}
