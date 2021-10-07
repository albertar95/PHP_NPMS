<?php

namespace App\DTOs;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class reportParameterDTO extends Model
{
    public string $NidParameter;
    public string $ReportId;
    public string $ParameterKey;
    public string $ParameterValue;
    public Boolean $IsDeleted;
    public int $Type;//tiny int
}
