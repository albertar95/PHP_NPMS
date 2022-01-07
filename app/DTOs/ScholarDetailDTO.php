<?php

namespace App\DTOs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class scholarDetailDTO extends Model
{
    public string $NidScholar;
    public string $FirstName;
    public string $LastName;
    public string $NationalCode;
    public string $BirthDate;
    public string $FatherName;
    public string $Mobile;
    public string $MillitaryStatusTitle;
    public string $GradeTitle;
    public majorDTO $Major;
    public OrientationDTO $Oreintation;
    public string $CollegeTitle;
    public string $CollaborationTypeTitle;
    public Collection $Projects;
    public string $ProfilePicture;
    public bool $IsConfident;
}
