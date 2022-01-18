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
                                <div class="col-sm-5">
                                </div>
                                <div class="col-sm-2">
                                    <a href="#" id="btnExecute" class="btn btn-outline-success btn-user btn-block">اجرای
                                        گزارش</a>
                                </div>
                                <div class="col-sm-5">
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
    <script type="text/javascript">
        $(function() {
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
            $("#btnExecute").click(function(e) {
                e.preventDefault();
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
                        if (result.HasValue)
                            $("#Resultwrapper").html(result.Html);
                    },
                    error: function() {
                        $("#ErrorMessage").text('خطا در انجام عملیات.لطفا مجددا امتحان کنید')
                        $("#errorAlert").removeAttr('hidden')
                        window.setTimeout(function() {
                            $("#errorAlert").attr('hidden', 'hidden');
                        }, 5000);
                    }
                });
            });
        });

        function ExportResult(contextId, typo, reportname) {
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
                                success: function() {
                                },
                                error: function() {
                                }
                            });
                            break;
                        case 2:
                            $("#ScholarDataTable").tableHTMLExport({
                                type: 'csv',
                                filename: reportname + '.csv'
                            });
                            break;
                        case 3:
                            $("#ScholarDataTable").tableHTMLExport({
                                type: 'txt',
                                filename: reportname + '.txt'
                            });
                            break;
                    }
                    break;
            }
        }
    </script>
@endsection
@endsection
