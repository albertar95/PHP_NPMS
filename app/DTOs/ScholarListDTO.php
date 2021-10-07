<?php

namespace App\DTOs;

use Illuminate\Database\Eloquent\Model;

class scholarListDTO extends Model
{
    public string $NidScholar;
    public string $FirstName;
    public string $LastName;
    public string $NationalCode;
    public ?string $Grade;
    public string $MajorName;
    public string $OreintationName;
    public string $CollegeName;
}
