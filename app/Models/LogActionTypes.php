<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActionTypes extends Model
{
    use HasFactory;
    protected $table = 'log_action_types';
    protected $primaryKey = 'NidAction';
    public    $timestamps = false;
    public $incrementing = false;
    // protected $fillable = [];
        // protected $visible = [];
    // protected $hidden = [];
    public function logs()
    {
        return $this->hasMany(Logs::class);
    }
}
