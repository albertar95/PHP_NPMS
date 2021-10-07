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
    public string $CreateDate;
    public ?string $LastLoginDate;
    public ?int $IncorrectPasswordCount;
    public bool $IsLockedOut;
    public bool $IsDisabled;
    public bool $IsAdmin;
    public string $ProfilePicture;
}
