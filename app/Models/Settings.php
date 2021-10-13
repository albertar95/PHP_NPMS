<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Settings extends Model
{
    use HasFactory;
    protected $table = 'settings';
    protected $primaryKey = 'NidSetting';
    public $incrementing = false;
    public    $timestamps = false;
    protected $fillable = ['IsDeleted','SettingKey','SettingValue','SettingTitle'];
    // protected $fillable = [];
    // protected $visible = [];
    // protected $hidden = [];
}
