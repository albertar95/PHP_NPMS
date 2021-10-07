<?php

namespace App\Domains\Repositories;

use App\Domains\Eloquent\BaseRepository;
use App\Domains\Interfaces\IUserRepository;
use App\DTOs\DataMapper;
use App\DTOs\userDTO;
use App\DTOs\userInPermissionDTO;
use App\Models\Resources;
use App\Models\UserPermissions;
use App\Models\Users;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserRepository extends BaseRepository implements IUserRepository{
    public function __construct(Users $model)
    {
        parent::__construct($model);
    }
    public function GetUserDTOById(string $NidUser):userDTO
    {
        $tmpuser = $this->model->all()->where('NidUser','=',$NidUser)->firstOrFail();
        return DataMapper::MapToUserDTO($tmpuser);
    }
    public function AddUser(Users $User)
    {
        $User->Password = Hash::make($User->Password);
        $User->save();
    }
    public function GetUserDTOs(int $pagesize = 10) :Collection
    {
        $result = new Collection();
        if ($pagesize != 0)
        {
            $tmpUsers = $this->model->all()->where('IsDisabled','=',true)->take($pagesize);
            foreach ($tmpUsers as $User)
            {
                $result->push(DataMapper::MapToUserDTO($User));
            }
        }
        else
        {
            $tmpUsers = $this->model->all()->where('IsDisabled','=',true);
            foreach ($tmpUsers as $User)
            {
                $result->push(DataMapper::MapToUserDTO($User));
            }
        }
        return $result;
    }
    public function DisableUser(string $NidUser):bool
    {
        $tmpUser = $this->model->all()->where('NidUser','=',$NidUser)->firstOrFail();
        if (!is_null($tmpUser))
        {
            $tmpUser->IsDisabled = true;
            $tmpUser->save();
            return true;
        }
        else
            return false;
    }
    public function UpdateUser(Users $User):bool
    {
        $User->save();
        return true;
    }
    public function GetFilteredUserDTOs(int $FilterType):Collection
    {
        $result = new Collection();
        switch ($FilterType)
        {
            case 1:
                $tmpUser = $this->model->all()->where('IsDisabled','=',true);
                foreach ($tmpUser as $usr)
                {
                    $result->push(DataMapper::MapToUserDTO($usr));
                }
                break;
            case 2:
                $tmpUser = $this->model->all()->where('IsLockedOut','=',true);
                foreach ($tmpUser as $usr)
                {
                    $result->push(DataMapper::MapToUserDTO($usr));
                }
                break;
            case 3:
                $tmpUser = $this->model->all()->where('IsAdmin','=',true);
                foreach ($tmpUser as $usr)
                {
                    $result->push(DataMapper::MapToUserDTO($usr));
                }
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
    public function ChangeUserPassword(string $NidUser, string $NewPass) :string
    {
        $tmpUser = $this->model->all()->where('NidUser','=',$NidUser)->firstOrFail();
        if (!is_null($tmpUser))
        {
            $tmpUser->Password = Hash::make($NewPass);
            $tmpUser->save();
            return $tmpUser->Password;
        }else
            return "";
    }
    public function LoginUser(string $Username, string $Password)
    {
        $tmpUser = $this->GetUserByUsername($Username);
        $resultFlag = 0;
        if (!is_null($tmpUser))
        {
            if ($tmpUser->Password == Hash::make($Password))
                $resultFlag = 1;
            else
                $resultFlag = 2;
        }
        else
            $esultFlag = 3;
        // return new Tuple<byte, string>(resultFlag, tmpUser.NidUser);
    }
    public function GetUserByUsername(string $Username):userDTO
    {
        return DataMapper::MapToUserDTO($this->model->all()->where('Username','=',trim($Username))->firstOrFail());
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
    public function UpdateUserUserPermission(string $NidUser,Collection $Resources):bool
    {
        try
        {
            $CurrentPermissions = UserPermissions::all()->where('UserId','=',$NidUser);
            $ProcessedResources = new Collection();
            foreach ($CurrentPermissions as $permission)
            {
                if (!$Resources->Contains($permission->ResourceId))
                {
                    $permission->delete();
                }
            }
            $tmpResources = Resources::all();
            foreach ($tmpResources as $Resource)
            {
                if (!$CurrentPermissions->GroupBy('ResourceId')->Select('ResourceId')->Contains($Resource))
                {
                    $ProcessedResources->push($Resource);
                }
            }
            foreach ($ProcessedResources as $processed)
            {
                $tmpPermission = new UserPermissions();
                $tmpPermission->NidPermission = Str::uuid();
                $tmpPermission->ResourceId = $processed;
                $tmpPermission->UserId = $NidUser;
                $tmpPermission->save();
            }
            return true;
        }
        catch (\Exception)
        {
            return false;
        }
    }
}

class UserRepositoryFactory
{
    public static function GetUserRepositoryObj():IUserRepository
    {
        return new UserRepository(new Users());
    }

}
