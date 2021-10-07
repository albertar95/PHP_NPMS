@extends('Layouts.app')

@section('Content')
{{-- @model List<DataAccessLibrary.DTOs.ReportDTO> --}}
    {{-- @{
        ViewBag.Title = "گزارشات آماری";
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
            <h6 class="m-0 font-weight-bold text-primary" style="text-align:right;">گزارشات آماری</h6>
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
            <div class="table-responsive" dir="ltr">
                <table class="table table-bordered" id="dataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                    <thead>
                        <tr>
                            <th>نام گزارش</th>
                            <th>بر اساس</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>نام گزارش</th>
                            <th>بر اساس</th>
                            <th>عملیات</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($Report as $rpt)
                        {
                            <tr>
                                <td>{{ $rpt->ReportName }}</td>
                                @switch ({{ $rpt->ContextId }})
                                {
                                    @case(1)
                                        <td>محقق</td>
                                        @break
                                    @case(2)
                                        <td>طرح</td>
                                        @break
                                    @case(3)
                                        <td>اطلاعات پایه</td>
                                        @break
                                    @case(4)
                                        <td>کاربر</td>
                                        @break
                                @endswitch
                                <td>
                                    <a href="{{ link_to_route('report.ExecuteReport','',[$NidReport = $rpt->NidReport]) }}" class="btn btn-outline-success">اجرای گزارش</a>
                                    <button class="btn btn-outline-danger" onclick="ShowModal('{{ $rpt->NidReport }}')">حذف</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal" id="ReportModal" tabindex="-1" role="dialog" aria-labelledby="ReportModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ReportModalLabel">حذف گزارش</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="ReportModalBody">
                </div>
                <p id="DeleteQuestion" style="margin:0 auto;font-size:xx-large;font-weight:bolder;">آیا برای حذف کامل این گزارش اطمینان دارید؟</p>
                <div class="modal-footer">
                    <div class="col-lg-12">
                        <button class="btn btn-success" type="button" style="margin:0 auto;width:15%;" id="btnOk">بلی</button>
                        <button class="btn btn-danger" type="button" style="margin:0 0 0 35%;width:15%;" data-dismiss="modal" id="btnCancel">خیر</button>
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
                var successdelete = '@TempData["DeleteReportSuccessMessage"]';
                if (successdelete != '') {
                    $("#SuccessMessage").text(successdelete);
                    $("#successAlert").removeAttr('hidden')
                    window.setTimeout(function () { $("#successAlert").attr('hidden', 'hidden'); }, 5000);
                }
            });
            function ShowModal(NidReport)
            {
                $("#btnOk").attr('onclick', 'DeleteReport(' + "'" + NidReport + "'" + ')');
                $("#ReportModal").modal('show');
            }
            function DeleteReport(NidReport)
            {
                $.ajax(
                    {
                        url: '@Url.Action("DeleteReport", "Home")',
                        type: 'post',
                        datatype: 'json',
                        data: { NidReport: NidReport },
                        success: function (result)
                        {
                            if(result.HasValue)
                                window.location.reload()
                            else
                            {
                                $("#ReportModal").modal('hide');
                                $("#ErrorMessage").text('خطا در انجام عملیات.لطفا مجددا امتحان کنید');
                                $("#errorAlert").removeAttr('hidden');
                                window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden'); }, 5000);
                            }
                        },
                        error: function ()
                        {
                            $("#ReportModal").modal('hide');
                            $("#ErrorMessage").text('خطا در انجام عملیات.لطفا مجددا امتحان کنید');
                            $("#errorAlert").removeAttr('hidden');
                            window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden'); }, 5000);
                        }
                    });
            }
    </script>
    @endsection
@endsection
