@extends('Layouts.app')

@section('Content')
{{-- @model NPMS_WebUI.ViewModels.ReportViewModel
@{
    ViewBag.Title = "گزارش آماری";
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
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">{{ $ReportName }}</h1>
                    </div>
                    @if (!is_null($inputs))
                        {{ $round = $inputs->Count / 3; }}
                    @endif
                    <form class="user" id="ExecuteReportForm">
                        <input type="text" class="form-control form-control-user" value="{{ $report->NidReport }}" id="NidReport" hidden>
                        @for ($i = 0; $i <= $round; $i++)
                            @if (!is_null($inputs))
                                <div class="form-group row" style="display:flex;">
                                    @foreach ($inputs.orderBy('NidParameter')->skip($i*3)->take(3) as $inp)
                                    <div class="col-sm-4" style="text-align:right;">
                                        <div style="display:flex;">
                                            {{-- @Html.Partial("_ExecuteReportPartial",new Tuple<int,string>(Model.report.ContextId,inp.ParameterKey)) --}}
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @endif
                        @endfor
                        <div class="form-group row" style="text-align:right;">
                            <div class="col-sm-3" style="padding:.5rem;">
                                <label>خروجی ها : </label>
                            </div>
                        </div>
                        <div class="form-group row" style="text-align:right;" id="OutputDiv">
                            @foreach ($outputs as $outy)
                                <div class="col-sm-4">
                                    <div class="row" style="display:flex;">
                                        <input type="checkbox" style="width:1rem;margin:unset !important;" id="{{ $outy->ParameterKey }}" class="form-control checkbox" alt="out" checked />
                                        {{-- <label for="{{ outy->ParameterKey }}" style="margin:.45rem .45rem 0 0">@NPMS_WebUI.ViewModels.SharedLayoutViewModel.ReportParametersInfos.Where(p => p.ParameterType == 1 && p.FieldName == outy.ParameterKey).FirstOrDefault().PersianName</label> --}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-5">
                            </div>
                            <div class="col-sm-2">
                                <a href="#" id="btnExecute" class="btn btn-outline-success btn-user btn-block">اجرای گزارش</a>
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

@section ('styles')
    <link href="{{ URL('Content/vendor/PersianDate/css/persian-datepicker.min.css') }}" rel="stylesheet" />
@endsection
@section ('scripts')
<script src="{{ URL('Content/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ URL('Content/vendor/ExportTable/tableHTMLExport.js') }}"></script>
<script src="{{ URL('Content/vendor/ExportTable/pdfmake.min.js') }}"></script>
<script src="{{ URL('Content/vendor/ExportTable/html2canvas.min.js') }}"></script>
<script src="{{ URL('Content/vendor/PersianDate/js/persian-date.min.js') }}"></script>
<script src="{{ URL('Content/vendor/PersianDate/js/persian-datepicker.min.js') }}"></script>
    <script type="text/javascript">
        $(function ()
        {
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
            $("#btnExecute").click(function (e)
            {
                e.preventDefault();
                var paramKeys = [];
                var paramVals = [];
                var selectedOutputs = [];
                $('.inputParams').each(function () {
                    paramKeys.push($(this).attr('id'));
                    paramVals.push($(this).val());
                });
                $("input:checkbox").each(function () {
                    if ($(this).is(":checked")) {
                        if ($(this).attr('alt') == 'out') {
                            selectedOutputs.push($(this).attr('id'));
                        }
                    }
                });
                $.ajax(
                    {
                        url: '@Url.Action("SubmitStatisticsReport", "Home")',
                        type: 'post',
                        datatype: 'json',
                        data: { NidReport: $("#NidReport").val(), PrameterKeys: paramKeys, ParameterValues: paramVals, OutPutValues:selectedOutputs },
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
                            html2canvas($('#ScholarDataTable')[0], {
                                onrendered: function (canvas) {
                                    var data = canvas.toDataURL();
                                    var docDefinition = {
                                        content: [{
                                            image: data,
                                            width: 500
                                        }]
                                    };
                                    pdfMake.createPdf(docDefinition).download(reportname + ".pdf");
                                }
                            });
                            break;
                        case 2:
                            $("#ScholarDataTable").tableHTMLExport(
                                {
                                    type: 'csv',
                                    filename: reportname + '.csv'
                                });
                            break;
                        case 3:
                            $("#ScholarDataTable").tableHTMLExport(
                                {
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
