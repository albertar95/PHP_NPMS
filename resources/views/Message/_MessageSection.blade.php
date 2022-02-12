{{-- @model List<DataAccessLibrary.DTOs.MessageDTO> --}}
{{-- @{
        NPMS_WebUI.ViewModels.SharedLayoutViewModel slvm = new NPMS_WebUI.ViewModels.SharedLayoutViewModel(DataAccessLibrary.Helpers.Encryption.Decrypt(User.Identity.Name).Split(','), 0);
        if (HttpContext.Current.Request.Cookies.AllKeys.Contains("NPMS_Permissions"))
        {
            var ticket = FormsAuthentication.Decrypt(HttpContext.Current.Request.Cookies["NPMS_Permissions"].Value);
            slvm.UserPermissions = new NPMS_WebUI.ViewModels.SharedLayoutViewModel(new string[] { ticket.UserData }, 1).UserPermissions;
        }
        else
        {
            slvm.UserPermissions = new List<Guid>();
        }
    } --}}
<h6 class="dropdown-header" style="text-align:center;">
    پیام ها
</h6>
@if (in_array('5', $sharedData['UserAccessedEntities']))
    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 5)->pluck('rowValue')[0])[4] == 1)
        @foreach ($messages as $msg)
            <a class="dropdown-item d-flex align-items-center" href="/singlemessage/{{ $msg->NidMessage }}/1">
                <div class="dropdown-list-image mr-3">
                    @if (!empty($msg->UserProfile))
                        <img src="{{ sprintf('/storage/images/%s', $msg->UserProfile) }}"
                            class="img-profile rounded-circle" />
                    @else
                        <img class="img-profile rounded-circle" src="{{ URL('Content/img/User/user3.png') }}">
                    @endforelse
                    {{-- <img class="rounded-circle" src="{{ URL('Content/img/User/user3.png') }}" alt="..."> --}}
                    <div class="status-indicator bg-success"></div>
                </div>
                <div class="font-weight-bold">
                    <div class="text-truncate">
                        {{ $msg->Title }}
                    </div>
                    <div class="small text-gray-500" style="text-align:right;">{{ $msg->SenderName }}</div>
                </div>
            </a>
        @endforeach
        <a class="dropdown-item text-center small text-gray-500" href="/messages/{{ auth()->user()->NidUser }}">نمایش
            تمامی پیام ها</a>
    @endif
@endif
