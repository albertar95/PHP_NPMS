<?php

namespace App\DTOs;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class userInPermissionDTO extends Model
{
    public string $NidUser;
    public string $Username;
    public string $FirstName;
    public string $LastName;
    public bool $IsAdmin;
}
