@extends('Layouts.app')

@section('Content')
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">{{ $report->ReportName }}</h1>
                        </div>
                        <form class="user" id="ExecuteReportForm">
                            <input type="text" class="form-control form-control-user" value="{{ $report->NidReport }}"
                                id="NidReport" hidden>
                            {!! $inputHtml !!}
                            <div class="form-group row" style="text-align:right;">
                                <div class="col-sm-3" style="padding:.5rem;">
                                    <label>خروجی ها : </label>
                                </div>
                            </div>
                            <div class="form-group row" style="text-align:right;" id="OutputDiv">
                                {!! $outputHtml !!}
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4 col-md-4 col-lg-5">
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-2">
                                    <a href="#" id="btnExecute" class="btn btn-outline-success btn-user btn-block">اجرای
                                        گزارش</a>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-5">
                                </div>
                            </div>
                        </form>
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
                        <p style="font-size:large;text-align: center;color: lightcoral;margin-top: 0.5rem;" id="waitText" hidden>لطفا منتظر بمانید</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow" style="margin-bottom:1rem;">
        <!-- Card Header - Accordion -->
        <a href="#collapseSearchResultItems" class="d-block card-header py-3" data-toggle="collapse" role="button"
            aria-expanded="true" aria-controls="collapseSearchResultItems">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align:center;">نتیجه گزارش</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" style="padding:.75rem;" id="collapseSearchResultItems">
            <div class="card-body" id="Resultwrapper">
            </div>
        </div>
    </div>

@section('styles')
    <link href="{{ URL('Content/vendor/PersianDate/css/persian-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <title>سامانه مدیریت تحقیقات - گزارش</title>
@endsection
@section('scripts')
    <script src="{{ URL('Content/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/ExportTable/tableHTMLExport.js') }}"></script>
    <script src="{{ URL('Content/vendor/ExportTable/pdfmake.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/ExportTable/html2canvas.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/ExportTable/jspdf.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/ExportTable/jspdf.plugin.autotable.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-date.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-datepicker.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL('Content/js/demo/datatables-demo.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('#ScholarDataTable').DataTable();
            $("#BirthDate").persianDatepicker({
                altField: '#BirthDate',
                altFormat: "YYYY/MM/DD",
                observer: true,
                format: 'YYYY/MM/DD',
                timePicker: {
                    enabled: false
                },
                initialValue: false,
                autoClose: true,
                responsive: true,
                maxDate: new persianDate()
            });
            $("#LastLoginDate").persianDatepicker({
                altField: '#LastLoginDate',
                altFormat: "YYYY/MM/DD",
                observer: true,
                format: 'YYYY/MM/DD',
                timePicker: {
                    enabled: false
                },
                initialValue: false,
                autoClose: true,
                responsive: true,
                maxDate: new persianDate()
            });
            $("#ATFLetterDate").persianDatepicker({
                altField: '#ATFLetterDate',
                altFormat: "YYYY/MM/DD",
                observer: true,
                format: 'YYYY/MM/DD',
                timePicker: {
                    enabled: false
                },
                initialValue: false,
                autoClose: true,
                responsive: true,
                maxDate: new persianDate()
            });
            $("#SixtyPercentLetterDate").persianDatepicker({
                altField: '#SixtyPercentLetterDate',
                altFormat: "YYYY/MM/DD",
                observer: true,
                format: 'YYYY/MM/DD',
                timePicker: {
                    enabled: false
                },
                initialValue: false,
                autoClose: true,
                responsive: true,
                maxDate: new persianDate()
            });
            $("#ThirtyPercentLetterDate").persianDatepicker({
                altField: '#ThirtyPercentLetterDate',
                altFormat: "YYYY/MM/DD",
                observer: true,
                format: 'YYYY/MM/DD',
                timePicker: {
                    enabled: false
                },
                initialValue: false,
                autoClose: true,
                responsive: true,
                maxDate: new persianDate()
            });
            $("#ThesisDefenceLetterDate").persianDatepicker({
                altField: '#ThesisDefenceLetterDate',
                altFormat: "YYYY/MM/DD",
                observer: true,
                format: 'YYYY/MM/DD',
                timePicker: {
                    enabled: false
                },
                initialValue: false,
                autoClose: true,
                responsive: true,
                maxDate: new persianDate()
            });
            $("#ThesisDefenceDate").persianDatepicker({
                altField: '#ThesisDefenceDate',
                altFormat: "YYYY/MM/DD",
                observer: true,
                format: 'YYYY/MM/DD',
                timePicker: {
                    enabled: false
                },
                initialValue: false,
                autoClose: true,
                responsive: true,
                maxDate: new persianDate()
            });
            $("#SecurityLetterDate").persianDatepicker({
                altField: '#SecurityLetterDate',
                altFormat: "YYYY/MM/DD",
                observer: true,
                format: 'YYYY/MM/DD',
                timePicker: {
                    enabled: false
                },
                initialValue: false,
                autoClose: true,
                responsive: true,
                maxDate: new persianDate()
            });
            $("#ImploymentDate").persianDatepicker({
                altField: '#ImploymentDate',
                altFormat: "YYYY/MM/DD",
                observer: true,
                format: 'YYYY/MM/DD',
                timePicker: {
                    enabled: false
                },
                initialValue: false,
                autoClose: true,
                responsive: true,
                maxDate: new persianDate()
            });
            $("#PreImploymentLetterDate").persianDatepicker({
                altField: '#PreImploymentLetterDate',
                altFormat: "YYYY/MM/DD",
                observer: true,
                format: 'YYYY/MM/DD',
                timePicker: {
                    enabled: false
                },
                initialValue: false,
                autoClose: true,
                responsive: true,
                maxDate: new persianDate()
            });
            $("#ImploymentDate").persianDatepicker({
                altField: '#ImploymentDate',
                altFormat: "YYYY/MM/DD",
                observer: true,
                format: 'YYYY/MM/DD',
                timePicker: {
                    enabled: false
                },
                initialValue: false,
                autoClose: true,
                responsive: true,
                maxDate: new persianDate()
            });
            $("#PreImploymentLetterDate").persianDatepicker({
                altField: '#PreImploymentLetterDate',
                altFormat: "YYYY/MM/DD",
                observer: true,
                format: 'YYYY/MM/DD',
                timePicker: {
                    enabled: false
                },
                initialValue: false,
                autoClose: true,
                responsive: true,
                maxDate: new persianDate()
            });
            $("#TenPercentLetterDate").persianDatepicker({
                altField: '#TenPercentLetterDate',
                altFormat: "YYYY/MM/DD",
                observer: true,
                format: 'YYYY/MM/DD',
                timePicker: {
                    enabled: false
                },
                initialValue: false,
                autoClose: true,
                responsive: true,
                maxDate: new persianDate()
            });
            $("#PersianCreateDate").persianDatepicker({
                altField: '#PersianCreateDate',
                altFormat: "YYYY/MM/DD",
                observer: true,
                format: 'YYYY/MM/DD',
                timePicker: {
                    enabled: false
                },
                initialValue: false,
                autoClose: true,
                responsive: true,
                maxDate: new persianDate()
            });
            $("#btnExecute").click(function(e) {
                e.preventDefault();
                $("#waitText").removeAttr('hidden')
                if (CheckValidity()) {
                    $("#warningAlert").attr('hidden', 'hidden');
                    var paramKeys = [];
                    var paramVals = [];
                    var selectedOutputs = [];
                    $('.inputParams').each(function() {
                        paramKeys.push($(this).attr('id'));
                        paramVals.push($(this).val());
                    });
                    $("input:checkbox").each(function() {
                        if ($(this).is(":checked")) {
                            if ($(this).attr('alt') == 'out') {
                                selectedOutputs.push($(this).attr('id'));
                            }
                        }
                    });
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/submitstatisticsreport',
                        type: 'post',
                        datatype: 'json',
                        data: {
                            NidReport: $("#NidReport").val(),
                            PrameterKeys: paramKeys,
                            ParameterValues: paramVals,
                            OutPutValues: selectedOutputs
                        },
                        success: function(result) {
                            $("#waitText").attr('hidden', 'hidden');
                            if (result.HasValue)
                                $("#Resultwrapper").html(result.Html);
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
                } else {
                    $("#waitText").attr('hidden', 'hidden');
                    $("#WarningMessage").text('لطفا ورودی های گزارش را وارد نمایید')
                    $("#warningAlert").removeAttr('hidden')
                    window.setTimeout(function() {
                        $("#warningAlert").attr('hidden', 'hidden');
                    }, 10000);
                }
            });
        });

        function ExportResult(contextId, typo, reportname) {
            $("#waitText2").removeAttr('hidden')
            switch (contextId) {
                case 1:
                    switch (typo) {
                        case 1:
                            var paramKeys = [];
                            var paramVals = [];
                            var selectedOutputs = [];
                            $('.inputParams').each(function() {
                                paramKeys.push($(this).attr('id'));
                                paramVals.push($(this).val());
                            });
                            $("input:checkbox").each(function() {
                                if ($(this).is(":checked")) {
                                    if ($(this).attr('alt') == 'out') {
                                        selectedOutputs.push($(this).attr('id'));
                                    }
                                }
                            });
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: '/downloadstatisticsreport',
                                type: 'post',
                                datatype: 'json',
                                data: {
                                    NidReport: $("#NidReport").val(),
                                    PrameterKeys: paramKeys,
                                    ParameterValues: paramVals,
                                    OutPutValues: selectedOutputs
                                },
                                success: function()
                                {
                                    $("#waitText2").attr('hidden', 'hidden');
                                },
                                error: function()
                                {
                                    $("#waitText2").attr('hidden', 'hidden');
                                }
                            });
                            break;
                        case 2:
                            $("#ScholarDataTable").tableHTMLExport({
                                type: 'csv',
                                filename: reportname + '.csv'
                            });
                            $("#waitText2").attr('hidden', 'hidden');
                            break;
                        case 3:
                            var paramKeys = [];
                            var paramVals = [];
                            var selectedOutputs = [];
                            $('.inputParams').each(function() {
                                paramKeys.push($(this).attr('id'));
                                paramVals.push($(this).val());
                            });
                            $("input:checkbox").each(function() {
                                if ($(this).is(":checked")) {
                                    if ($(this).attr('alt') == 'out') {
                                        selectedOutputs.push($(this).attr('id'));
                                    }
                                }
                            });
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: '/printstatisticsreport',
                                type: 'post',
                                datatype: 'json',
                                data: {
                                    NidReport: $("#NidReport").val(),
                                    PrameterKeys: paramKeys,
                                    ParameterValues: paramVals,
                                    OutPutValues: selectedOutputs
                                },
                                success: function(result) {
                                    $("#waitText2").attr('hidden', 'hidden');
                                    if (result.HasValue) {
                                        newWin = window.open("");
                                        newWin.document.write(result.Html);
                                        newWin.print();
                                        newWin.close();
                                    } else {
                                        var divToPrint = document.getElementById("ScholarDataTable");
                                        newWin = window.open("");
                                        newWin.document.write(divToPrint.outerHTML);
                                        newWin.print();
                                        newWin.close();
                                    }
                                },
                                error: function() {
                                    $("#waitText2").attr('hidden', 'hidden');
                                    var divToPrint = document.getElementById("ScholarDataTable");
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

        function CheckValidity() {
            const slts = ["GradeId", "MajorId", "OreintationId", "MillitaryStatus", "UnitId", "GroupId", "UserId",
                "RoleId"
            ];
            var output = true;
            $('.inputParams').each(function() {
                if (slts.includes($(this).attr('id'))) {
                    if ($(this).val() == "0" || !$(this).val())
                        output = false;
                } else {
                    if (!$(this).val())
                        output = false;
                }
            });
            return output;
        }
    </script>
@endsection
@endsection
