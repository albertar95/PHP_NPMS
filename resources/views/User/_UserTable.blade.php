{{-- @model List<DataAccessLibrary.DTOs.UserDTO>
    @{
        NPMS_WebUI.ViewModels.SharedLayoutViewModel slvm1 = null;
        if (HttpContext.Current.Request.Cookies.AllKeys.Contains("NPMS_Permissions"))
        {
            var ticket = FormsAuthentication.Decrypt(HttpContext.Current.Request.Cookies["NPMS_Permissions"].Value);
            slvm1 = new NPMS_WebUI.ViewModels.SharedLayoutViewModel(new string[] { ticket.UserData }, 1);
        }
        else
        {
            slvm1.UserPermissions = new List<Guid>();
        }
    } --}}
    <thead>
        <tr>
            <th>تصویر</th>
            <th>مشخصات کاربر</th>
            <th>نام کاربری</th>
            <th>سطح کاربری</th>
            <th>عملیات</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>تصویر</th>
            <th>مشخصات کاربر</th>
            <th>نام کاربری</th>
            <th>سطح کاربری</th>
            <th>عملیات</th>
        </tr>
    </tfoot>
    <tbody>
        @if (!empty($Users))
        @foreach ($Users as $usr)
        <tr>
            <td>
            @if (!empty($usr->ProfilePicture))
                <img src="/storage/images/{{ $usr->ProfilePicture }}" height="50" width="50" />
            @else
                <img height="50" width="50" src="{{ URL('Content/img/User/user3.png') }}">
            @endforelse
            </td>
            <td>{{ $usr->FirstName}} {{ $usr->LastName }}</td>
            <td>{{ $usr->Username }}</td>
            <td>{{ $usr->RoleTitle }}</td>
            <td>
                {{-- @if (slvm1.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "UserDetail").FirstOrDefault().Id))
                {
                    <button class="btn btn-secondary" onclick="ShowModal(1,'@usr.NidUser')">جزییات</button>
                }
                @if (slvm1.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "EditUser").FirstOrDefault().Id))
                {
                    <a href="@Url.Action("EditUser","Home",new { NidUser = usr.NidUser})" class="btn btn-warning">ویرایش</a>
                }
                @if (slvm1.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "DisableUser").FirstOrDefault().Id))
                {
                    <button class="btn btn-danger" onclick="ShowModal(2,'@usr.NidUser')">غیرفعال</button>
                } --}}
                <button class="btn btn-secondary" onclick="ShowModal(1,'{{ $usr->NidUser }}')">جزییات</button>
                <a href="edituser/{{ $usr->NidUser }}" class="btn btn-warning">ویرایش</a>
                <button class="btn btn-danger" onclick="ShowModal(2,'@usr.NidUser')">غیرفعال</button>
            </td>
        </tr>
    @endforeach
        @endif
    </tbody>





