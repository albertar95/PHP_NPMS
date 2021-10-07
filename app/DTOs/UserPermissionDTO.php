<?php

namespace App\DTOs;

use Illuminate\Database\Eloquent\Model;

class userPermissionDTO extends Model
{
    public string $NidPermission;
    public string $UserId;
    public string $ResourceId;
}
