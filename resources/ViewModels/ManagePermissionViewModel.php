<?php

namespace resources\ViewModels;

use App\DTOs\userInPermissionDTO;
use Illuminate\Support\Collection;

class ManagePermissionViewModel
{
    public Collection $UserPermissions;
    public userInPermissionDTO $User;
    public Collection $Resources;
}
