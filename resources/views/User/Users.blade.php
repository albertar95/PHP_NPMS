@extends('Layouts.app')

@section('Content')
{{-- @model List<DataAccessLibrary.DTOs.UserDTO>
    @{
        ViewBag.Title = "مدیریت کاربران";
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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align:right;">مدیریت کاربران</h6>
        </div>
        <div class="card-body">
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
            <div class="row" style="margin-bottom:1rem;">
                @if (slvm1.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "AddUser").FirstOrDefault().Id))
                {
                    <a class="btn btn-outline-success btn-block" style="margin:.25rem;width:15%;" href="@Url.Action("AddUser","Home")">ایجاد کاربر</a>
                }
                <a id="btnDisabled" onclick="ChangeTableSource(1)" class="btn btn-outline-secondary btn-block" style="margin:.25rem;width:15%;" href="#">نمایش کاربران غیرفعال</a>
                <a id="btnLockout"  onclick="ChangeTableSource(2)" class="btn btn-outline-dark btn-block" style="margin:.25rem;width:15%;" href="#">نمایش کاربران تعلیق شده</a>
                <a id="btnAdmin"    onclick="ChangeTableSource(3)" class="btn btn-outline-info btn-block" style="margin:.25rem;width:15%;" href="#">نمایش کاربران ادمین</a>
                <a id="btnOnline"   onclick="ChangeTableSource(4)" class="btn btn-outline-primary btn-block" style="margin:.25rem;width:15%;" href="#">نمایش کاربران برخط</a>
                <a id="btnDefault" onclick="ChangeTableSource(5)" class="btn btn-outline-warning btn-block" style="margin:.25rem;width:15%;" href="#">حالت پیش فرض</a>
            </div>
            <div class="table-responsive" dir="ltr" id="tableWrapper">
                <table class="table table-bordered" id="dataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
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
                        @foreach ($Users as $usr)
                        {
                            <tr>
                                <td>
                                    @if (!isEmptyOrNull($usr->ProfilePicture))
                                        {{ $imgSrc = string.sprintf("data:image/jpg;base64,%s", $usr->ProfilePicture); }}
                                        <img src="{{ $imgSrc }}" height="100" width="100" />
                                    @endif
                                    @else
                                        <img height="100" width="100" src="@Url.Content("~/Content/img/User/user3.png")">
                                    @endforelse
                                </td>
                                <td>{{ $usr->FirstName &nbsp; $usr->LastName }}</td>
                                <td>{{ $usr->Username }}</td>
                                @if ($usr->IsAdmin)
                                    <td>کاربر عادی</td>
                                @endif
                                @else
                                    <td>کاربر ادمین</td>
                                @endforelse
                                <td>
                                    @if (slvm1.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "UserDetail").FirstOrDefault().Id))
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
                                    }
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal" id="UserModal" tabindex="-1" role="dialog" aria-labelledby="UserModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="UserModalLabel"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="UserModalBody">
                </div>
                <p id="DeleteQuestion" style="margin:0 auto;font-size:xx-large;font-weight:bolder;" hidden>آیا برای غیرفعال نمودن این کاربر اطمینان دارید؟</p>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" id="btnClose" data-dismiss="modal" style="margin:0 auto;width:10%;" hidden>بستن</button>
                    <div class="col-lg-12">
                        <button class="btn btn-success" type="button" style="margin:0 auto;width:15%;" id="btnOk" hidden>بلی</button>
                        <button class="btn btn-danger" type="button" style="margin:0 0 0 35%;width:15%;" data-dismiss="modal" id="btnCancel" hidden>خیر</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section ('styles')
        <link href="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @endsection
    @section ('scripts')
        <script src="{{ URL('Content/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ URL('Content/js/demo/datatables-demo.js') }}"></script>
        <script type="text/javascript">
            $(function ()
            {
                var successedit = '@TempData["EditUserSuccessMessage"]';
                var erroredit = '@TempData["EditUserErrorMessage"]';
                var successdelete = '@TempData["DisableUserSuccessMessage"]';
                if(successedit != '')
                {
                    $("#SuccessMessage").text(successedit);
                    $("#successAlert").removeAttr('hidden')
                    window.setTimeout(function () { $("#successAlert").attr('hidden', 'hidden'); }, 10000);
                }
                if(erroredit != '')
                {
                    $("#ErrorMessage").text(erroredit);
                    $("#errorAlert").removeAttr('hidden')
                    window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden'); }, 10000);
                }
                if (successdelete != '') {
                    $("#SuccessMessage").text(successdelete);
                    $("#successAlert").removeAttr('hidden')
                    window.setTimeout(function () { $("#successAlert").attr('hidden', 'hidden'); }, 10000);
                }
            });
            function ShowModal(typo, NidUser)
            {
                if (typo == 1)
                {
                    $("#UserModalLabel").text('جزییات اطلاعات کاربر');
                    $("#btnClose").removeAttr('hidden');
                    $("#btnCancel").attr('hidden', 'hidden');
                    $("#btnOk").attr('hidden', 'hidden');
                    $("#DeleteQuestion").attr('hidden', 'hidden');
                }
                else if (typo == 2)
                {
                    $("#UserModalLabel").text('غیرفعال کردن کاربر');
                    $("#DeleteQuestion").removeAttr('hidden');
                    $("#btnOk").removeAttr('hidden');
                    $("#btnCancel").removeAttr('hidden');
                    $("#btnClose").attr('hidden', 'hidden');
                    $("#btnOk").attr('onclick', 'DisableUser(' + "'" + NidUser + "'" + ')');
                }
                $.ajax(
                    {
                        url: '@Url.Action("UserDetail", "Home")',
                        type: 'post',
                        datatype: 'json',
                        data: { NidUser: NidUser },
                        success: function (result)
                        {
                            if(result.HasValue)
                            {
                                $("#UserModalBody").html(result.Html)
                                $("#UserModal").modal('show')
                            }
                        },
                        error: function () { }
                    })
            }
            function DisableUser(NidUser)
            {
                $.ajax(
                    {
                        url: '@Url.Action("DisableUser", "Home")',
                        type: 'post',
                        datatype: 'json',
                        data: { NidUser: NidUser },
                        success: function (result)
                        {
                            if(result.HasValue)
                                window.location.reload()
                            else
                            {
                                $("#UserModal").modal('hide');
                                $("#ErrorMessage").text(result.Message);
                                $("#errorAlert").removeAttr('hidden');
                                window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden'); }, 10000);

                            }
                        },
                        error: function () { }
                    });
            }
            function ChangeTableSource(sourceId)
            {
                $.ajax(
                    {
                        url: '@Url.Action("UserSourceChange", "Home")',
                        type: 'post',
                        datatype: 'json',
                        data: { SourceId: sourceId },
                        success: function (result) {
                            $("#dataTable").html(result.Html)
                        },
                        error: function () { }
                    });
            }
        </script>
    @endsection


@endsection
