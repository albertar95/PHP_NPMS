<?php

namespace App\DTOs;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class userDTO extends Model
{
    // 'LockoutDeadLine' => $User->LockoutDeadLine,
    // 'LastPasswordChangeDate' => $User->LastPasswordChangeDate,
    // 'last_seen' => $User->last_seen,
    // 'Force_logout' => $User->Force_logout,
    // 'ProfilePicture' => $User->ProfilePicture
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
    public string $RoleId;
    public string $RoleTitle;
    public ?string $ProfilePicture;
}
