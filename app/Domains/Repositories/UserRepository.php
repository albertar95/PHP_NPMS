<?php

namespace App\Domains\Repositories;

use App\Domains\Eloquent\BaseRepository;
use App\Domains\Interfaces\IUserRepository;
use App\DTOs\DataMapper;
use App\DTOs\userDTO;
use App\DTOs\userInPermissionDTO;
use App\Models\PasswordHistory;
use App\Models\Resources;
use App\Models\RolePermissions;
use App\Models\Roles;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserPermissions;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserRepository extends BaseRepository implements IUserRepository{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
    public function GetUserDTOById(string $NidUser):userDTO
    {
        $tmpuser = $this->model->all()->where('NidUser','=',$NidUser)->firstOrFail();
        return DataMapper::MapToUserDTO($tmpuser);
    }
    public function AddUser(User $User)
    {
        $User->Password = Hash::make($User->Password);
        return $User->save();
    }
    public function GetUserDTOs(int $pagesize = 10) :Collection
    {
        $result = new Collection();
        if ($pagesize != 0)
        {
            $tmpUsers = $this->model->all()->where('IsDisabled','=',0)->take($pagesize);
            foreach ($tmpUsers as $User)
            {
                $result->push(DataMapper::MapToUserDTO($User));
            }
        }
        else
        {
            $tmpUsers = $this->model->all()->where('IsDisabled','=',0);
            foreach ($tmpUsers as $User)
            {
                $result->push(DataMapper::MapToUserDTO($User));
            }
        }
        return $result;
    }
    public function GetOnlineUserDTOs(int $pagesize = 10) :Collection
    {
        $result = new Collection();
        if ($pagesize != 0)
        {
            $tmpUsers = $this->model->all()->where('IsDisabled','=',0)->whereNotNull('last_seen')->sortByDesc('last_seen')->take($pagesize);
            foreach ($tmpUsers as $User)
            {
                $result->push(DataMapper::MapToUserDTO($User));
            }
        }
        else
        {
            $tmpUsers = $this->model->all()->where('IsDisabled','=',0)->whereNotNull('last_seen')->sortByDesc('last_seen');
            foreach ($tmpUsers as $User)
            {
                $result->push(DataMapper::MapToUserDTO($User));
            }
        }
        return $result;
    }
    public function DisableUser(string $NidUser)
    {
        $tmpUser = $this->model->all()->where('NidUser','=',$NidUser)->firstOrFail();
        if (!is_null($tmpUser))
        {
            User::where('NidUser',$NidUser)->update(
                [
                    'IsDisabled' => boolval(true)
                ]
                );
                return $tmpUser;
        }
        else
            return null;
    }
    public function LogoutUser(string $NidUser)
    {
        $tmpUser = $this->model->all()->where('NidUser','=',$NidUser)->firstOrFail();
        if (!is_null($tmpUser))
        {
            User::where('NidUser',$NidUser)->update(
                [
                    'Force_logout' => boolval(true)
                ]
                );
                return $tmpUser;
        }
        else
            return null;
    }
    public function UpdateUser(User $User):bool
    {
        User::where('NidUser',$User->NidUser)->update(
            [
                'UserName' => $User->UserName,
                'Password' => $User->Password,
                'FirstName' => $User->FirstName,
                'LastName' => $User->LastName,
                'CreateDate' => $User->CreateDate,
                'LastLoginDate' => $User->LastLoginDate,
                'IncorrectPasswordCount' => $User->IncorrectPasswordCount,
                'IsLockedOut' => boolval($User->IsLockedOut),
                'IsDisabled' => boolval($User->IsDisabled),
                'RoleId' => $User->RoleId,
                'LockoutDeadLine' => $User->LockoutDeadLine,
                'LastPasswordChangeDate' => $User->LastPasswordChangeDate,
                'ProfilePicture' => $User->ProfilePicture
            ]
            );
            return true;
    }
    public function GetFilteredUserDTOs(int $FilterType):Collection
    {
        $result = new Collection();
        switch ($FilterType)
        {
            case 1:
                $tmpUser = $this->model->all()->where('IsDisabled','=',1);
                foreach ($tmpUser as $usr)
                {
                    $result->push(DataMapper::MapToUserDTO($usr));
                }
                break;
            case 2:
                $tmpUser = $this->model->all()->where('IsLockedOut','=',1);
                foreach ($tmpUser as $usr)
                {
                    $result->push(DataMapper::MapToUserDTO($usr));
                }
                break;
            case 3:
                // $tmpUser = $this->model->all()->where('IsAdmin','=',1);
                // foreach ($tmpUser as $usr)
                // {
                //     $result->push(DataMapper::MapToUserDTO($usr));
                // }
                break;
            case 4:
                // foreach (var usr in db.Users.Where(p => p.LastLoginDate >= DateTime.Parse(DateTime.Now.ToShortDateString())))
                // {
                //     result.Add(mapper.MapToUserDTO(usr));
                // }
                break;
            case 5:
                $result = $this->GetUserDTOs(0);
                break;
        }
        return $result;
    }
    public function CheckPreviousPassword(string $NidUser, string $NewPass) :bool
    {
        $result = true;
        $tmpPasswords = PasswordHistory::all()->where('NidUser','=',$NidUser)->sortByDesc('CreateDate')->take(3);
        if (!is_null($tmpPasswords))
        {
            foreach ($tmpPasswords as $Pass) {
                if (Hash::check($NewPass, $Pass->Password))
                {
                    $result = false;
                }
            }
        }
        return $result;
    }
    public function ChangeUserPassword(string $NidUser, string $NewPass) :string
    {
        $tmpUser = $this->model->all()->where('NidUser','=',$NidUser)->firstOrFail();
        if (!is_null($tmpUser))
        {
            $passhistory = new PasswordHistory();
            $passhistory->NidUser = $NidUser;
            $passhistory->Password = $tmpUser->Password;
            $passhistory->CreateDate = Carbon::now();
            $passhistory->save();
            User::where('NidUser',$NidUser)->update(
                [
                    'Password' => Hash::make($NewPass),
                    'LastPasswordChangeDate' => Carbon::now()
                ]
                );
                return User::all()->where('NidUser','=',$NidUser)->firstOrFail()->Password;
        }else
            return "";
    }
    public function LoginUser(string $Username, string $Password)
    {
        $tmpUser = $this->GetUserByUsername($Username);
        $resultFlag = 0;
        $dateNow = Carbon::now();
        if (!is_null($tmpUser))
        {
            if($tmpUser->IsLockedOut && $dateNow->lt($tmpUser->LockoutDeadLine))
            {
                $resultFlag = 4;
            }else
            {
                if(is_null($tmpUser->LastPasswordChangeDate) || $dateNow->diffInDays($tmpUser->LastPasswordChangeDate) > 45)
                $resultFlag = 5;
                else
                {
                    if (Hash::check($Password, $tmpUser->Password))
                    {
                        $tmpUser->IsLockedOut = 0;
                        $tmpUser->LastLoginDate = Carbon::now();
                        $tmpUser->IncorrectPasswordCount = 0;
                        $this->UpdateUser($tmpUser);
                        $resultFlag = 1;
                    }
                    else
                    {
                        $tmpUser->IncorrectPasswordCount = $tmpUser->IncorrectPasswordCount + 1;
                        if($tmpUser->IncorrectPasswordCount >= 5)
                        {
                            $tmpUser->IsLockedOut = 1;
                            $tmpUser->LockoutDeadLine = $dateNow->addMinutes(1);
                            $tmpUser->IncorrectPasswordCount = 0;
                        }
                        $this->UpdateUser($tmpUser);
                        $resultFlag = 2;
                    }
                }
            }
        }
        else
            $resultFlag = 3;
        return response()->json(['result'=>$resultFlag,'nidUser'=>$tmpUser->NidUser]);
    }
    public function GetUserDTOByUsername(string $Username):userDTO
    {
        return DataMapper::MapToUserDTO($this->model->all()->where('UserName','=',trim($Username))->firstOrFail());
    }
    public function GetUserByUsername(string $Username):User
    {
        return $this->model->all()->where('UserName','=',trim($Username))->firstOrFail();
        // return User::with('role')->where('UserName','=',trim($Username))->firstOrFail();
    }
    public function GetUserPermissionUsers(int $Pagesize = 10):Collection
    {
        $result = new Collection();
        if($Pagesize == 0)
        {
            $tmpUsers = $this->model->all()->where('IsDisabled','=',false);
            foreach ($tmpUsers as $user)
            {
                $result->push(DataMapper::MapToUserInPermissionDTO($user));
            }
        }
        else
        {
            $tmpUsers = $this->model->all()->where('IsDisabled','=',false)->take($Pagesize);
            foreach ($tmpUsers as $user)
            {
                $result->push(DataMapper::MapToUserInPermissionDTO($user));
            }
        }
        return $result;
    }
    public function GetUserInPermissionById(string $NidUser) :userInPermissionDTO
    {
        return DataMapper::MapToUserInPermissionDTO($this->model->all()->where('NidUser','=',$NidUser)->firstOrFail());
    }
    public function GetResources(int $pagesize = 100):Collection
    {
        $result = new Collection();
        if($pagesize == 0)
        {
            $tmpResources = Resources::all();
            foreach ($tmpResources as $Resources)
            {
                $result->push(DataMapper::MapToResourceDTO($Resources));
            }
        }
        else
        {
            $tmpResources = Resources::all()->take($pagesize);
            foreach ($tmpResources as $Resources)
            {
                $result->push(DataMapper::MapToResourceDTO($Resources));
            }
        }
        return $result;
    }
    public function GetUserPermissions(string $NidUser) :Collection
    {
        $result = new Collection();
        $tmpPermissions = UserPermissions::all()->where('UserId','=',$NidUser);
        foreach ($tmpPermissions as $perm)
        {
            $result->push(DataMapper::MapToUserPermissionDTO($perm));
        }
        return $result;
    }
    public function UpdateUserUserPermission(string $NidUser,array $Resources)
    {
        // try
        // {
        //     var CurrentPermissions = db.UserPermissions.Where(p => p.UserId == NidUser).ToList();
        //     List<Guid> ProcessedResources = new List<Guid>();
        //     foreach (var cur in CurrentPermissions)
        //     {
        //         if (!Resources.Contains(cur.ResourceId))
        //         {
        //             db.Entry(cur).State = System.Data.Entity.EntityState.Deleted;
        //             db.SaveChanges();
        //         }
        //     }
        //     foreach (var rsc1 in Resources)
        //     {
        //         if (!CurrentPermissions.GroupBy(p => p.ResourceId).Select(q => q.Key).Contains(rsc1))
        //         {
        //             ProcessedResources.Add(rsc1);
        //         }
        //     }
        //     foreach (var rsc in ProcessedResources)
        //     {
        //         db.UserPermissions.Add(new UserPermission() { NidPermission = Guid.NewGuid(), ResourceId = rsc, UserId = NidUser });
        //         db.SaveChanges();
        //     }
        //     return true;
        // }
        // catch (Exception ex)
        // {
        //     return false;
        // }


        $CurrentPermissions = UserPermissions::all()->where('UserId','=',$NidUser);
        $ProcessedResources = new Collection();
        $toadds = array_diff($Resources,$CurrentPermissions->toArray());
        if($Resources != null)
        {
            $todeletes = array_diff($CurrentPermissions->toArray(),$Resources);
            foreach ($todeletes as $del) {
                UserPermissions::all()->where('UserId','=',$NidUser)->where('ResourceId','=',$del)->firstOrFail()->delete();
            }
        }else
        {
            foreach (UserPermissions::all()->where('UserId','=',$NidUser) as $perm) {
                $perm->delete();
            }
        }
        foreach ($toadds as $add) {
            $tmpPermission = new UserPermissions();
            $tmpPermission->NidPermission = Str::uuid();
            $tmpPermission->ResourceId = $add;
            $tmpPermission->UserId = $NidUser;
            $tmpPermission->save();
        }
        return true;
    }
    public function UpdateUserPasswordPolicy(array $policy)
    {
        if(!is_null($policy['PasswordDificulty']))
        {
            if(Settings::all()->where('SettingTitle','=','PasswordPolicies')->where('SettingKey','=','PasswordDificulty')->count() > 0)
            {
                Settings::all()->where('SettingTitle','=','PasswordPolicies')->where('SettingKey','=','PasswordDificulty')->firstOrFail()->update(
                    [
                        'SettingValue' => $policy['PasswordDificulty']
                    ]);
            }else
            {
                $newSet = new Settings();
                $newSet->NidSetting = Str::uuid();
                $newSet->SettingKey = 'PasswordDificulty';
                $newSet->SettingValue = $policy['PasswordDificulty'];
                $newSet->SettingTitle = 'PasswordPolicies';
                $newSet->IsDeleted = boolval(0);
                $newSet->save();
            }
        }
        if(!is_null($policy['FullLockoutUser']))
        {
            if(Settings::all()->where('SettingTitle','=','PasswordPolicies')->where('SettingKey','=','FullLockoutUser')->count() > 0)
            {
                Settings::all()->where('SettingTitle','=','PasswordPolicies')->where('SettingKey','=','FullLockoutUser')->firstOrFail()->update(
                    [
                        'SettingValue' => $policy['FullLockoutUser']
                    ]);
            }else
            {
                $newSet = new Settings();
                $newSet->NidSetting = Str::uuid();
                $newSet->SettingKey = 'FullLockoutUser';
                $newSet->SettingValue = $policy['FullLockoutUser'];
                $newSet->SettingTitle = 'PasswordPolicies';
                $newSet->IsDeleted = boolval(0);
                $newSet->save();
            }
        }
        if(!is_null($policy['PasswordLength']))
        {
            if(Settings::all()->where('SettingTitle','=','PasswordPolicies')->where('SettingKey','=','PasswordLength')->count() > 0)
            {
                Settings::all()->where('SettingTitle','=','PasswordPolicies')->where('SettingKey','=','PasswordLength')->firstOrFail()->update(
                    [
                        'SettingValue' => $policy['PasswordLength']
                    ]);
            }else
            {
                $newSet = new Settings();
                $newSet->NidSetting = Str::uuid();
                $newSet->SettingKey = 'PasswordLength';
                $newSet->SettingValue = $policy['PasswordLength'];
                $newSet->SettingTitle = 'PasswordPolicies';
                $newSet->IsDeleted = boolval(0);
                $newSet->save();
            }
        }
        if(!is_null($policy['ChangePasswordDuration']))
        {
            if(Settings::all()->where('SettingTitle','=','PasswordPolicies')->where('SettingKey','=','ChangePasswordDuration')->count() > 0)
            {
                Settings::all()->where('SettingTitle','=','PasswordPolicies')->where('SettingKey','=','ChangePasswordDuration')->firstOrFail()->update(
                    [
                        'SettingValue' => $policy['ChangePasswordDuration']
                    ]);
            }else
            {
                $newSet = new Settings();
                $newSet->NidSetting = Str::uuid();
                $newSet->SettingKey = 'ChangePasswordDuration';
                $newSet->SettingValue = $policy['ChangePasswordDuration'];
                $newSet->SettingTitle = 'PasswordPolicies';
                $newSet->IsDeleted = boolval(0);
                $newSet->save();
            }
        }
        if(!is_null($policy['LastPasswordCount']))
        {
            if(Settings::all()->where('SettingTitle','=','PasswordPolicies')->where('SettingKey','=','LastPasswordCount')->count() > 0)
            {
                Settings::all()->where('SettingTitle','=','PasswordPolicies')->where('SettingKey','=','LastPasswordCount')->firstOrFail()->update(
                    [
                        'SettingValue' => $policy['LastPasswordCount']
                    ]);
            }else
            {
                $newSet = new Settings();
                $newSet->NidSetting = Str::uuid();
                $newSet->SettingKey = 'LastPasswordCount';
                $newSet->SettingValue = $policy['LastPasswordCount'];
                $newSet->SettingTitle = 'PasswordPolicies';
                $newSet->IsDeleted = boolval(0);
                $newSet->save();
            }
        }
        if(!is_null($policy['IncorrectAttemptCount']))
        {
            if(Settings::all()->where('SettingTitle','=','PasswordPolicies')->where('SettingKey','=','IncorrectAttemptCount')->count() > 0)
            {
                Settings::all()->where('SettingTitle','=','PasswordPolicies')->where('SettingKey','=','IncorrectAttemptCount')->firstOrFail()->update(
                    [
                        'SettingValue' => $policy['IncorrectAttemptCount']
                    ]);
            }else
            {
                $newSet = new Settings();
                $newSet->NidSetting = Str::uuid();
                $newSet->SettingKey = 'IncorrectAttemptCount';
                $newSet->SettingValue = $policy['IncorrectAttemptCount'];
                $newSet->SettingTitle = 'PasswordPolicies';
                $newSet->IsDeleted = boolval(0);
                $newSet->save();
            }
        }
        if(!is_null($policy['LockoutDuration']))
        {
            if(Settings::all()->where('SettingTitle','=','PasswordPolicies')->where('SettingKey','=','LockoutDuration')->count() > 0)
            {
                Settings::all()->where('SettingTitle','=','PasswordPolicies')->where('SettingKey','=','LockoutDuration')->firstOrFail()->update(
                    [
                        'SettingValue' => $policy['LockoutDuration']
                    ]);
            }else
            {
                $newSet = new Settings();
                $newSet->NidSetting = Str::uuid();
                $newSet->SettingKey = 'LockoutDuration';
                $newSet->SettingValue = $policy['LockoutDuration'];
                $newSet->SettingTitle = 'PasswordPolicies';
                $newSet->IsDeleted = boolval(0);
                $newSet->save();
            }
        }
        return true;
    }
    public function GetUserPasswordPolicy()
    {
        return Settings::all()->where('SettingTitle','=','PasswordPolicies');
    }
    public function AddRole(Roles $role)
    {
        return $role->save();
    }
    public function UpdateRole(Roles $role)
    {
        if(Roles::all()->where('NidRole','=',$role->NidRole)->count() > 0)
        {
            Roles::all()->where('NidRole','=',$role->NidRole)->firstOrFail()->update(
                [
                    'Title' => $role->Title,
                    'IsAdmin' => $role->IsAdmin
                ]);
        }
    }
    public function DeleteRole(string $NidRole)
    {
        //first need to check for user assigns
        Roles::all()->where('NidRole','=',$NidRole)->firstOrFail()->delete();
        return true;
    }
    public function GetRoles()
    {
        return Roles::all();
    }
    public function AddRolePermission(RolePermissions $role)
    {
        $role->save();
    }
    public function UpdateRolePermission(RolePermissions $role)
    {
        RolePermissions::all()->where('NidPermission','=',$role->NidPermission)->firstOrFail()->update(
            [
                'RoleId' => $role->RoleId,
                'EntityId' => $role->EntityId,
                'Create' => $role->Create,
                'Edit' => $role->Edit,
                'Delete' => $role->Delete,
                'Detail' => $role->Detail,
                'Confident' => $role->Confident,
                'List' => $role->List,
                'Print' => $role->Print
            ]);
            return true;
    }
    public function DeleteRolePermission(string $NidPermission)
    {
        RolePermissions::all()->where('NidPermission','=',$NidPermission)->firstOrFail()->delete();
    }
    public function GetRolesPermission()
    {
        return RolePermissions::all();
    }
    public function GetRolesPermissionByUserId(string $NidUser)
    {
        $tmpRoleId = User::all()->where('NidUser','=',$NidUser)->firstOrFail()->RoleId;
        return RolePermissions::all()->where('RoleId','=',$tmpRoleId);
    }
    public function GetRolesPermissionById(string $NidPermission)
    {
        return RolePermissions::all()->where('NidPermission','=',$NidPermission)->firstOrFail();
    }
    public function UpdateSessionSetting(string $newValue)
    {
        if(Settings::all()->where('SettingTitle','=','SessionSetting')->where('SettingKey','=','SessionTimeout')->count() > 0)
        {
            Settings::all()->where('SettingTitle','=','SessionSetting')->where('SettingKey','=','SessionTimeout')->firstOrFail()->update(
                [
                    'SettingValue' => $newValue
                ]);
        }else
        {
            $newSet = new Settings();
            $newSet->NidSetting = Str::uuid();
            $newSet->SettingKey = 'SessionTimeout';
            $newSet->SettingValue = $newValue;
            $newSet->SettingTitle = 'SessionSetting';
            $newSet->IsDeleted = boolval(0);
            $newSet->save();
        }
    }
    public function GetSessionSettings()
    {
        return Settings::all()->where('SettingTitle','=','SessionSetting');
    }
}

class UserRepositoryFactory
{
    public static function GetUserRepositoryObj():IUserRepository
    {
        return new UserRepository(new User());
    }

}
