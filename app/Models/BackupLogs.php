<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupLogs extends Model
{
    use HasFactory;
    protected $table = 'backup_logs';
    protected $primaryKey = 'NidLog';
    public $incrementing = false;
    public    $timestamps = false;
}
