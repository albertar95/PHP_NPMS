@extends('Layouts.app')

@section('Content')
{{-- @model List<DataAccessLibrary.DTOs.ScholarListDTO>

    @{
        ViewBag.Title = "مدیریت محققان";
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
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align:right;">مدیریت محققان</h6>
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
            {{-- @if (slvm1.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "AddScholar").FirstOrDefault().Id))
            {
                <div class="row" style="margin-bottom:1rem;">
                    <a class="btn btn-outline-success btn-block" style="margin:1rem;width:15%;" href="@Url.Action("AddScholar","Home")">ایجاد محقق</a>
                </div>
            } --}}
            <div class="table-responsive" dir="ltr">
                <table class="table table-bordered" id="dataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                    <thead>
                        <tr>
                            <th>نام محقق</th>
                            <th>کد ملی</th>
                            <th class="priority-1">مقطع تحصیلی</th>
                            <th class="priority-2">رشته</th>
                            <th class="priority-3">گرایش</th>
                            <th class="priority-4">محل تحصیل</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>نام محقق</th>
                            <th>کد ملی</th>
                            <th class="priority-1">مقطع تحصیلی</th>
                            <th class="priority-2">رشته</th>
                            <th class="priority-3">گرایش</th>
                            <th class="priority-4">محل تحصیل</th>
                            <th>عملیات</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($Scholar as $sch)
                            <tr>
                                <td>{{ $sch->FirstName ?? "" }}{{  $sch->LastName ?? "" }}</td>
                                <td>{{ $sch->NationalCode ?? "" }}</td>
                                <td class="priority-1">{{ $sch->Grade ?? ""}}</td>
                                <td class="priority-2">{{ $sch->MajorName ?? ""}}</td>
                                <td class="priority-3">{{ $sch->OreintationName ?? ""}}</td>
                                <td class="priority-4">{{ $sch->collegeName ?? ""}}</td>
                                <td>
                                    {{-- @if (slvm1.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "ScholarDetail").FirstOrDefault().Id))
                                    {
                                        <button class="btn btn-secondary" onclick="ShowModal(1,'{{ $sch->NidScholar }}')">جزییات</button>
                                    }
                                    @if (slvm1.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "EditScholar").FirstOrDefault().Id))
                                    {
                                        <a href="{{ route('scholar.EditScholar',$sch->NidScholar) }}" class="btn btn-warning">ویرایش</a>
                                    }
                                    @if (slvm1.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "DeleteScholar").FirstOrDefault().Id))
                                    {
                                        <button class="btn btn-danger" onclick="ShowModal(2,'{{ $sch->NidScholar }}')">حذف</button>
                                    } --}}
                                    <button class="btn btn-danger" onclick="ShowModal(2,'{{ $sch->NidScholar }}')">حذف</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal" id="ScholarModal" tabindex="-1" role="dialog" aria-labelledby="ScholarModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ScholarModalLabel"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="ScholarModalBody">
                </div>
                <p id="DeleteQuestion" style="margin:0 auto;font-size:xx-large;font-weight:bolder;" hidden>آیا برای حذف این محقق اطمینان دارید؟</p>
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
                // var successedit = '@TempData["EditScholarSuccessMessage"]';
                // var erroredit = '@TempData["EditScholarErrorMessage"]';
                // var successdelete = '@TempData["DeleteScholarSuccessMessage"]';
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
            function ShowModal(typo,NidScholar)
            {
                if (typo == 1)
                {
                    $("#ScholarModalLabel").text('جزییات اطلاعات محقق');
                    $("#btnClose").removeAttr('hidden');
                    $("#btnCancel").attr('hidden', 'hidden');
                    $("#btnOk").attr('hidden', 'hidden');
                    $("#DeleteQuestion").attr('hidden', 'hidden');
                }
                else if (typo == 2)
                {
                    $("#ScholarModalLabel").text('حذف محقق');
                    $("#DeleteQuestion").removeAttr('hidden');
                    $("#btnOk").removeAttr('hidden');
                    $("#btnCancel").removeAttr('hidden');
                    $("#btnClose").attr('hidden', 'hidden');
                    $("#btnOk").attr('onclick', 'DeleteScholar(' + "'" + NidScholar + "'" + ')');
                }
                $.ajax(
                    {
                        url: '/scholardetail/' + NidScholar,
                        type: 'get',
                        datatype: 'json',
                        success: function (result)
                        {
                            if(result.HasValue)
                            {
                                $("#ScholarModalBody").html(result.Html)
                                $("#ScholarModal").modal('show')
                            }
                        },
                        error: function () { }
                    })
            }
            function DeleteScholar(NidScholar)
            {
                $.ajax(
                    {
                        url: '/deletescholar/' + NidScholar,//'@Url.Action("DeleteScholar","Home")',
                        type: 'get',
                        datatype: 'json',
                        success: function (result)
                        {
                            if(result.Message == "1")
                                window.location.reload()
                            else if(result.Message == "2")
                            {
                                $("#ScholarModal").modal('hide');
                                $("#ErrorMessage").text(result.Html);
                                $("#errorAlert").removeAttr('hidden');
                                window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden'); }, 10000);

                            }else if(result.Message == "3")
                            {
                                $("#ScholarModal").modal('hide');
                                $("#WarningMessage").text(result.Html);
                                $("#warningAlert").removeAttr('hidden');
                                window.setTimeout(function () { $("#warningAlert").attr('hidden', 'hidden'); }, 10000);
                            }
                        },
                        error: function () { }
                    });
            }
        </script>
        @endsection
@endsection
