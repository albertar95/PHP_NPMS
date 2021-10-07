<?php

namespace App\DTOs;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class userDTO extends Model
{
    public string $NidUser;
    public string $Username;
    public string $Password;
    public string $FirstName;
    public string $LastName;
    public DateTime $CreateDate;
    public DateTime $LastLoginDate;
    public int $IncorrectPasswordCount;
    public Boolean $IsLockedOut;
    public Boolean $IsDisabled;
    public Boolean $IsAdmin;
    public string $ProfilePicture;
}
