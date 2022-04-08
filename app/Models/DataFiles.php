<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataFiles extends Model
{
    use HasFactory;
    protected $table = 'data_files';
    protected $primaryKey = 'NidFile';
    public $incrementing = false;
    public    $timestamps = false;
    protected $fillable = ['NidMaster','MasterType','FilePath','FileName','FileExtension','IsDeleted','CreateDate','DeleteDate'];
}
