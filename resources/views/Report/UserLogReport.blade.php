@extends('Layouts.app')

@section('Content')
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5" style="min-height: 500px;">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">گزارش عملکرد کاربران</h1>
                        </div>
                        @if (in_array('0', $sharedData['UserAccessedEntities']))
                            <form class="user" id="ExecuteReportForm">
                                {{-- <input type="text" class="form-control form-control-user" value="{{ $report->NidReport }}" id="NidReport" hidden> --}}
                                <div class="form-group row" style="text-align:right;">
                                    <div class="col-sm-2" style="padding:.5rem;display: flex;">
                                        {{-- <label>تاریخ از : </label> --}}
                                        <input type="text" class="form-control form-control-user" id="FromDate"
                                            name="FromDate" placeholder="تاریخ از">
                                    </div>
                                    <div class="col-sm-2" style="padding:.5rem;display: flex;">
                                        {{-- <label>تاریخ از : </label> --}}
                                        <input type="text" class="form-control form-control-user" id="ToDate" name="ToDate"
                                            placeholder="تاریخ تا">
                                    </div>
                                    <div class="col-sm-2" style="padding:.5rem;display: flex;">
                                        <select class="form-control allWidth" name="LogActionId" id="LogActionId"
                                            placeholder="انتخاب نوع فعالیت">
                                            {{-- <option data-tokens="نوع فعالیت" selected>نوع فعالیت</option> --}}
                                            <option data-tokens="همه" value="0">همه</option>
                                            @foreach ($LogActionTypes->sortBy('Title') as $logaction)
                                                <option value="{{ $logaction->NidAction }}"
                                                    data-tokens="{{ $logaction->Title }}">{{ $logaction->Title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-2" style="padding:.5rem;display: flex;">
                                        {{-- <label>تاریخ از : </label> --}}
                                        <input type="text" class="form-control form-control-user" id="UserName"
                                            name="UserName" placeholder="نام کاربری">
                                    </div>
                                    <div class="col-sm-2" style="padding:.5rem;display: flex;">
                                        <button type="submit" id="btnExecute" class="btn btn-success btn-user btn-block"
                                            style="margin:auto;">
                                            اجرای گزارش
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                        <div class="alert alert-success alert-dismissible" role="alert" id="successAlert" hidden>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <p style="text-align:right;" id="SuccessMessage"></p>
                        </div>
                        <div class="alert alert-warning alert-dismissible" role="alert" id="warningAlert" hidden>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <p style="text-align:right;" id="WarningMessage"></p>
                        </div>
                        <div class="alert alert-danger alert-dismissible" role="alert" id="errorAlert" hidden>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <p style="text-align:right;" id="ErrorMessage"></p>
                        </div>
                        <p style="font-size:large;text-align: center;color: lightcoral;margin-top: 0.5rem;" id="waitText"
                            hidden>لطفا منتظر بمانید</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow" style="margin-bottom:1rem;">
        <!-- Card Header - Accordion -->
        <a href="#collapseSearchResultItems" class="d-block card-header py-3" style="text-align:right;"
            data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseSearchResultItems">
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
    <link href="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <title>سامانه مدیریت تحقیقات - گزارش عملکرد کاربران</title>
@endsection
@section('scripts')
    <script src="{{ URL('Content/vendor/ExportTable/tableHTMLExport.js') }}"></script>
    <script src="{{ URL('Content/vendor/ExportTable/html2canvas.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-date.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-datepicker.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL('Content/js/demo/datatables-demo.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('#LogActionId').selectize({
                sortField: 'value'
            });
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
            $("#btnExecute").click(function(e) {
                e.preventDefault();
                $("#waitText").removeAttr('hidden')
                if (!$("#FromDate").val() || !$("#ToDate").val()) {
                    $("#WarningMessage").text('لطفا ورودی های گزارش را وارد نمایید')
                    $("#warningAlert").removeAttr('hidden')
                    window.setTimeout(function() {
                        $("#warningAlert").attr('hidden', 'hidden');
                    }, 10000);
                    $("#waitText").attr('hidden', 'hidden');
                } else {
                    $("#warningAlert").attr('hidden', 'hidden');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ URL::to('/') }}' + '/submituserlogreport',
                        type: 'post',
                        datatype: 'json',
                        data: {
                            FromDate: $("#FromDate").val(),
                            ToDate: $("#ToDate").val(),
                            LogActionId: $("#LogActionId").val(),
                            UserName: $("#UserName").val()
                        },
                        success: function(result) {
                            $("#waitText").attr('hidden', 'hidden');
                            if (result.HasValue)
                                $("#Resultwrapper").html(result.Html);
                            $('#logsDataTable').DataTable({
                                "order": [
                                    [0, "desc"],
                                    [1, "desc"]
                                ],
                            });
                        },
                        error: function() {
                            $("#waitText").attr('hidden', 'hidden');
                            $("#ErrorMessage").text(
                                'خطا در انجام عملیات.لطفا مجددا امتحان کنید')
                            $("#errorAlert").removeAttr('hidden')
                            window.setTimeout(function() {
                                $("#errorAlert").attr('hidden', 'hidden');
                            }, 5000);
                        }
                    });
                }
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
                            // $.ajax({
                            //     url: '{{ URL::to('/') }}' + '/downloaduserlogreport',
                            //     type: 'post',
                            //     datatype: 'json',
                            //     data: {
                            //         FromDate: $("#FromDate").val(),
                            //         ToDate: $("#ToDate").val(),
                            //         LogActionId: $("#LogActionId").val(),
                            //         UserName: $("#UserName").val()
                            //     },
                            //     success: function() {},
                            //     error: function() {}
                            // });
                            $.ajax({
                                type: 'GET',
                                url: '{{ URL::to('/') }}' + '/downloaduserlogreport',
                                data: {
                                    FromDate: $("#FromDate").val(),
                                    ToDate: $("#ToDate").val(),
                                    LogActionId: $("#LogActionId").val(),
                                    UserName: $("#UserName").val()
                                },
                                xhrFields: {
                                    responseType: 'blob'
                                },
                                success: function(response) {
                                    var blob = new Blob([response]);
                                    var link = document.createElement('a');
                                    link.href = window.URL.createObjectURL(blob);
                                    link.download = "گزارش عملکرد کاربران.pdf";
                                    link.click();
                                },
                                error: function(blob) {
                                    console.log(blob);
                                }
                            });
                            break;
                        case 2:
                            $("#logsDataTable").tableHTMLExport({
                                type: 'csv',
                                filename: reportname + '.csv'
                            });
                            break;
                        case 3:
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: '{{ URL::to('/') }}' + '/printuserlogreport',
                                type: 'post',
                                datatype: 'json',
                                data: {
                                    FromDate: $("#FromDate").val(),
                                    ToDate: $("#ToDate").val(),
                                    LogActionId: $("#LogActionId").val(),
                                    UserName: $("#UserName").val()
                                },
                                success: function(result) {
                                    if (result.HasValue) {
                                        newWin = window.open("");
                                        newWin.document.write(result.Html);
                                        newWin.print();
                                        newWin.close();
                                    } else {
                                        var divToPrint = document.getElementById("logsDataTable");
                                        newWin = window.open("");
                                        newWin.document.write(divToPrint.outerHTML);
                                        newWin.print();
                                        newWin.close();
                                    }
                                },
                                error: function() {
                                    var divToPrint = document.getElementById("logsDataTable");
                                    newWin = window.open("");
                                    newWin.document.write(divToPrint.outerHTML);
                                    newWin.print();
                                    newWin.close();
                                }
                            });
                            break;
                    }
                    break;
            }
        }
    </script>
@endsection
