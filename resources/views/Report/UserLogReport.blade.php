@extends('Layouts.app')

@section('Content')
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">گزارش عملکرد کاربران</h1>
                    </div>
                    <form class="user" id="ExecuteReportForm">
                        {{-- <input type="text" class="form-control form-control-user" value="{{ $report->NidReport }}" id="NidReport" hidden> --}}
                        <div class="form-group row" style="text-align:right;">
                            <div class="col-sm-2" style="padding:.5rem;display: flex;">
                                {{-- <label>تاریخ از : </label> --}}
                                <input type="text" class="form-control form-control-user" id="FromDate" name="FromDate"
                                       placeholder="تاریخ از">
                            </div>
                            <div class="col-sm-2" style="padding:.5rem;display: flex;">
                                {{-- <label>تاریخ از : </label> --}}
                                <input type="text" class="form-control form-control-user" id="ToDate" name="ToDate"
                                       placeholder="تاریخ تا">
                            </div>
                            <div class="col-sm-2" style="padding:.5rem;display: flex;">
                                <select class="form-control allWidth" data-ng-style="btn-primary" name="LogActionId" id="LogActionId" style="padding:0 .75rem;">
                                    <option value="-1" disabled selected>نوع فعالیت</option>
                                    <option value="0">همه</option>
                                    @foreach ($LogActionTypes->sortBy('Title') as $logaction)
                                    <option value="{{ $logaction->NidAction }}">{{ $logaction->Title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2" style="padding:.5rem;display: flex;">
                                {{-- <label>تاریخ از : </label> --}}
                                <input type="text" class="form-control form-control-user" id="UserName" name="UserName"
                                       placeholder="نام کاربری">
                            </div>
                            <div class="col-sm-2" style="padding:.5rem;display: flex;">
                                <button type="submit" id="btnExecute" class="btn btn-success btn-user btn-block" style="margin:auto;">
                                    اجرای گزارش
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card shadow" style="text-align:right;margin-bottom:1rem;">
    <!-- Card Header - Accordion -->
    <a href="#collapseSearchResultItems" class="d-block card-header py-3" data-toggle="collapse"
       role="button" aria-expanded="true" aria-controls="collapseSearchResultItems">
        <h6 class="m-0 font-weight-bold text-primary" style="text-align:center;">نتیجه گزارش</h6>
    </a>
    <!-- Card Content - Collapse -->
    <div class="collapse show" style="padding:.75rem;" id="collapseSearchResultItems">
        <div class="card-body" id="Resultwrapper">
        </div>
    </div>
</div>
@endsection
@section('styles')
    <link href="{{ URL('Content/vendor/PersianDate/css/persian-datepicker.min.css') }}" rel="stylesheet" />
@endsection
@section('scripts')
<script src="{{ URL('Content/vendor/ExportTable/tableHTMLExport.js') }}"></script>
<script src="{{ URL('Content/vendor/ExportTable/html2canvas.min.js') }}"></script>
<script src="{{ URL('Content/vendor/PersianDate/js/persian-date.min.js') }}"></script>
<script src="{{ URL('Content/vendor/PersianDate/js/persian-datepicker.min.js') }}"></script>
<script type="text/javascript">
$(function()
{
                $("#FromDate").persianDatepicker({
                    altField: '#FromDate',
                    altFormat: 'YYYY/MM/DD',
                    observer: true,
                    format: 'YYYY/MM/DD',
                    timePicker: {
                        enabled: true
                    },
                    initialValue: false,
                    autoClose: true,
                    responsive: true,
                    maxDate: new persianDate()
                });
                $("#ToDate").persianDatepicker({
                    altField: '#ToDate',
                    altFormat: 'YYYY/MM/DD',
                    observer: true,
                    format: 'YYYY/MM/DD',
                    timePicker: {
                        enabled: true
                    },
                    initialValue: false,
                    autoClose: true,
                    responsive: true,
                    maxDate: new persianDate()
                });
                $("#btnExecute").click(function (e)
            {
                e.preventDefault();
                $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                $.ajax(
                    {
                        url: '/submituserlogreport',
                        type: 'post',
                        datatype: 'json',
                        data: { FromDate: $("#FromDate").val(), ToDate: $("#ToDate").val(), LogActionId: $("#LogActionId").val(), UserName:$("#UserName").val() },
                        success: function (result) {
                            if (result.HasValue)
                                $("#Resultwrapper").html(result.Html);
                        },
                        error: function () {
                            $("#ErrorMessage").text('خطا در انجام عملیات.لطفا مجددا امتحان کنید')
                            $("#errorAlert").removeAttr('hidden')
                            window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden'); }, 5000);
                        }
                    });
            });
});
function ExportResult(contextId, typo, reportname) {
            switch (contextId) {
                case 1:
                    switch (typo) {
                        case 1:
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: '/downloaduserlogreport',
                                type: 'post',
                                datatype: 'json',
                                data: { FromDate: $("#FromDate").val(), ToDate: $("#ToDate").val(), LogActionId: $("#LogActionId").val(), UserName:$("#UserName").val() },
                                success: function() {},
                                error: function() {}
                            });
                            break;
                        case 2:
                            $("#logsDataTable").tableHTMLExport({
                                type: 'csv',
                                filename: reportname + '.csv'
                            });
                            break;
                        case 3:
                            var divToPrint = document.getElementById("logsDataTable");
                            newWin = window.open("");
                            newWin.document.write(divToPrint.outerHTML);
                            newWin.print();
                            newWin.close();
                            break;
                    }
                    break;
            }
        }
</script>
@endsection
