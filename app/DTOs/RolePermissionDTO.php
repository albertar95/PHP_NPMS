<?php

namespace App\DTOs;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class RolePermissionDTO extends Model
{
    public string $NidPermission;
    public string $RoleId;
    public string $RoleTitle;
    public int $EntityId;
    public bool $Create;
    public bool $Edit;
    public bool $Delete;
    public bool $Detail;
    public bool $List;
    public bool $Print;
}
