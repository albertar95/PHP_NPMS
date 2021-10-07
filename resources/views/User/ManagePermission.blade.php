@extends('Layouts.app')

@section('Content')
{{-- @model NPMS_WebUI.ViewModels.ManagePermissionViewModel

@{
    ViewBag.Title = "اعمال دسترسی";
    Layout = "~/Views/Shared/_Layout.cshtml";
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

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                {{-- @if (slvm1.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "UserPermissions").FirstOrDefault().Id))
                {
                    <div dir="ltr">
                        <a id="btnReturn" class="btn btn-outline-info btn-block" style="margin:1rem;width:25%;" href="@Url.Action("UserPermissions","Home")">&larr; بازگشت</a>
                    </div>
                } --}}
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">اعمال دسترسی به کاربر</h1>
                    </div>
                        <div class="form-group row" style="text-align:right;">
                        <div class="col-sm-2" style="padding:.5rem;">
                            <label>نام کاربری : </label>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-control">@Model.User.Username</label>
                        </div>
                        <div class="col-sm-2" style="padding:.5rem;">
                            <label>مشخصات کاربر : </label>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-control" id="txtUserInfo">{{ $User->FirstName &nbsp; $User->LastName }}</label>
                        </div>
                    </div>
                          <div class="form-group row" style="text-align:right;">
                        <div class="col-sm-3" style="padding:.5rem;">
                            <label>دسترسی ها : </label>
                        </div>
                    </div>
                    {{ $counter = $Resources->Count / 3; }}
                    @for ($i = 0; $i < $counter; $i++)
                    {
                        <div class="form-group row" style="text-align:right;">
                            @foreach ($Resources.Where('ClassLevel','=',1)->orderBy('SortNumber')->skip($i * 3)->take(3))
                                <div class="col-sm-4">
                                        @if ($UserPermissions->Where('ResourceId','=',$res->NidResource)->count() > 0)
                                            <div class="row" style="display:flex;">
                                                <input type="checkbox" style="width:1rem;margin:unset !important;" id="{{ $res->NidResource }}" class="form-control checkbox" checked />
                                                <label for="{{ $res->NidResource }}" style="margin:.45rem .45rem 0 0">{{ $res->SortNumber . $res->ResourceName }}</label>
                                            </div>
                                            @if ($Resources->where('ClassLevel','=',2)->where('ParentId','=','NidResource')->count() > 0)
                                                @foreach ($resources->where('ClassLevel','=',2)->where('ParentId','=',$res->NidResource)->orderBy('SortNumber') as $res1)
                                                    <div class="row" style="display:flex;padding-right:1.5rem;">
                                                        @if ($UserPermissions->Where('ResourceId','=',$res1->NidResource)->count() > 0)
                                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="{{ $res1->NidResource }}" class="form-control checkboxChild" alt="@res1.ParentId" checked />
                                                            <label for="{{ $res1->NidResource }}" style="margin:.45rem .45rem 0 0">{{ $res1->ResourceName }}</label>
                                                        @endif
                                                        @else
                                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="{{ $res1->NidResource }}" class="form-control checkboxChild" alt="@res1.ParentId" />
                                                            <label for="{{ $res1->NidResource }}" style="margin:.45rem .45rem 0 0">{{ $res1->ResourceName }}</label>
                                                        @endforelse
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endif
                                        @else
                                            <div class="row" style="display:flex;">
                                                <input type="checkbox" style="width:1rem;margin:unset !important;" id="@res.NidResource" class="form-control checkbox" />
                                                <label for="@res.NidResource" style="margin:.45rem .45rem 0 0">@res.SortNumber . @res.ResourceName</label>
                                            </div>
                                            @if ($Resources->Where('ClassLevel','=',2)->where('ParentId','=',$res->NidResource)->count() > 0)
                                                @foreach ($Resources->Where('ClassLevel','=',2)->where('ParentId','=',$res->NidResource)->orderBy('SortNumber') as $res1)
                                                    <div class="row" style="display:flex;padding-right:1.5rem;">
                                                        @if ($UserPermissions->where('ResourceId','=',$res1->NidResource)->count() > 0)
                                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="{{ $res1->NidResource }}" class="form-control checkboxChild" alt="{{ $res1->ParentId }}" checked disabled />
                                                            <label for="{{ $res1->NidResource }}" style="margin:.45rem .45rem 0 0">{{ $res1->ResourceName }}</label>
                                                        @endif
                                                        @else
                                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="{{ $res1->NidResource }}" class="form-control checkboxChild" alt="{{ $res1->ParentId }}" disabled />
                                                            <label for="{{ $res1->NidResource }}" style="margin:.45rem .45rem 0 0">{{ $res1->ResourceName }}</label>
                                                        @endforelse
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endforelse
                                </div>
                            @endforeach
                        </div>
                    @endfor
                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-user btn-block" style="width:25%;margin:auto;margin-top:3rem;">
                            ذخیره اطلاعات
                        </button>
                    <hr />
                    <div class="alert alert-success alert-dismissible" role="alert" id="successAlert" hidden>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <p style="text-align:right;" id="SuccessMessage"></p>
                    </div>
                    <div class="alert alert-warning alert-dismissible" role="alert" id="warningAlert" hidden>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <p style="text-align:right;" id="WarningMessage"></p>
                    </div>
                    <div class="alert alert-danger alert-dismissible" role="alert" id="errorAlert" hidden>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <p style="text-align:right;" id="ErrorMessage"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section ('scripts')
    <script type="text/javascript">
        $(function ()
        {
            $('.checkbox').change(function ()
            {
                var currentId = $(this).attr('id');
                if ($(this).is(":checked"))
                {
                    $('.checkboxChild').each(function () {
                        if ($(this).attr('alt') == currentId) {
                            $(this).attr('disabled', false);
                        }
                    });
                } else
                {
                    $('.checkboxChild').each(function () {
                        if ($(this).attr('alt') == currentId) {
                            $(this).prop('checked', false);
                            $(this).attr('disabled', true);
                        }
                    });
                }
            });
            $("#btnSubmit").click(function (e)
            {
                e.preventDefault();
                var selectedResources = [];
                $("input:checkbox").each(function ()
                {
                    if($(this).is(":checked"))
                    {
                        selectedResources.push($(this).attr('id'));
                    }
                });
                $.ajax(
                    {
                        url: '@Url.Action("EditUserPermission","Home")',
                        type: 'post',
                        datatype: 'json',
                        data: { ResourceIds: selectedResources, UserId: '@Model.User.NidUser', UserInfo: '@Model.User.Username' },
                        success: function (result)
                        {
                            if(!result.HasValue)
                            {
                                $("#ErrorMessage").text('خطا در انجام عملیات.لطفا مجدد امتحان کنید');
                                $("#errorAlert").removeAttr('hidden');
                                window.setTimeout(function(){$("#errorAlert").attr('hidden','hidden')},5000);
                            } else
                            {
                                window.location = '@Url.Action("UserPermissions", "Home")';
                            }
                        },
                        error: function ()
                        {
                            $("#ErrorMessage").text('خطا در انجام عملیات.لطفا مجدد امتحان کنید');
                            $("#errorAlert").removeAttr('hidden');
                            window.setTimeout(function(){$("#errorAlert").attr('hidden','hidden')},5000);
                        }
                    });
            });
        });
    </script>
@endsection
@endsection
