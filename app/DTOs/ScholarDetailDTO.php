<?php

namespace App\DTOs;

use Illuminate\Database\Eloquent\Model;

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
    public OreintationDTO $Oreintation;
    public string $CollegeTitle;
    public string $CollaborationTypeTitle;
    public projectDTO $Projects;
    public string $ProfilePicture;
}
