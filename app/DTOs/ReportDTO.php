<?php

namespace App\DTOs;

use Illuminate\Database\Eloquent\Model;

class reportDTO extends Model
{
    public string $NidReport;
    public string $ReportName;
    public int $ContextId;
    public int $FieldId;
}
