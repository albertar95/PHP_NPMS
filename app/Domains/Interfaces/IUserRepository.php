<?php
namespace App\Domains\Interfaces;

use App\DTOs\userDTO;
use App\DTOs\userInPermissionDTO;
use App\Models\Users;
use Illuminate\Support\Collection;

interface IUserRepository
{
    public function GetUserDTOById(string $NidUser):userDTO;
    public function AddUser(Users $User);
    public function GetUserDTOs(int $pagesize = 10) :Collection;
    public function DisableUser(string $NidUser):bool;
    public function UpdateUser(Users $User):bool;
    public function GetFilteredUserDTOs(int $FilterType):Collection;
    public function ChangeUserPassword(string $NidUser, string $NewPass) :string;
    public function LoginUser(string $Username, string $Password);
    public function GetUserByUsername(string $Username):userDTO;
    public function GetUserPermissionUsers(int $Pagesize = 10):Collection;
    public function GetUserInPermissionById(string $NidUser) :userInPermissionDTO;
    public function GetResources(int $pagesize = 100):Collection;
    public function GetUserPermissions(string $NidUser) :Collection;
    public function UpdateUserUserPermission(string $NidUser,Collection $Resources):bool;
}
