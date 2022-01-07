<?php

namespace App\DTOs;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class scholarDTO extends Model
{
    public string $NidScholar;
    public string $FirstName;
    public string $LastName;
    public string $NationalCode;
    public ?string $BirthDate;
    public string $FatherName;
    public string $Mobile;
    public int $MillitaryStatus;//tiny int
    public int $GradeId;//tiny int
    public string $MajorId;
    public string $OreintationId;
    public int $college;
    public int $CollaborationTypeTitle;//tiny int
    public string $ProfilePicture;
    public string $UserId;
    public bool $IsDeleted;
    public ?DateTime $DeleteDate;
    public ?string $DeleteUser;
    public bool $IsConfident;
}
