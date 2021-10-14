<?php
namespace App\Domains\Interfaces;

use App\DTOs\userDTO;
use App\DTOs\userInPermissionDTO;
use App\Models\RolePermissions;
use App\Models\Roles;
use App\Models\User;
use App\Models\Users;
use Illuminate\Support\Collection;

interface IUserRepository
{
    public function GetUserDTOById(string $NidUser):userDTO;
    public function AddUser(User $User);
    public function GetUserDTOs(int $pagesize = 10) :Collection;
    public function DisableUser(string $NidUser):bool;
    public function UpdateUser(User $User):bool;
    public function GetFilteredUserDTOs(int $FilterType):Collection;
    public function ChangeUserPassword(string $NidUser, string $NewPass) :string;
    public function LoginUser(string $Username, string $Password);
    public function GetUserDToByUsername(string $Username):userDTO;
    public function GetUserByUsername(string $Username):User;
    public function GetUserPermissionUsers(int $Pagesize = 10):Collection;
    public function GetUserInPermissionById(string $NidUser) :userInPermissionDTO;
    public function GetResources(int $pagesize = 100):Collection;
    public function GetUserPermissions(string $NidUser) :Collection;
    public function UpdateUserUserPermission(string $NidUser,array $Resources);
    public function UpdateUserPasswordPolicy(array $policy);
    public function GetUserPasswordPolicy();
    //roles
    public function AddRole(Roles $role);
    public function UpdateRole(Roles $role);
    public function DeleteRole(string $NidRole);
    public function GetRoles();
    //role permissions
    public function AddRolePermission(RolePermissions $role);
    public function UpdateRolePermission(RolePermissions $role);
    public function DeleteRolePermission(string $NidRole);
    public function GetRolesPermission();
    public function GetRolesPermissionByUserId(string $NidUser);
    public function GetRolesPermissionById(string $NidPermission);
}
