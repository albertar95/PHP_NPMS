@extends('Layouts.app')

@section('Content')


<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4" style="text-align:center;">ایجاد گزارش</h1>
                    </div>
                    @if (in_array('4', $sharedData['UserAccessedEntities']))
                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 4)->pluck('rowValue')[0])[0] == 1)
                        <form class="user" enctype="application/x-www-form-urlencoded" id="AddReportForm">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="ReportName" name="ReportName"
                                       placeholder="نام گزارش">
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control allWidth" data-ng-style="btn-primary" id="sltContext" name="ContextId" style="padding:0 .75rem;">
                                    <option value="0" disabled selected>موجودیت گزارش</option>
                                    <option value="1">محقق</option>
                                    <option value="2">طرح</option>
                                    <option value="3">اطلاعات پایه</option>
                                    <option value="4">کاربر</option>
                                </select>
                            </div>
                        </div>
                        <div id="Partials">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <select class="form-control allWidth" data-ng-style="btn-primary" id="sltField" name="FieldId" onchange="FieldChange()" style="padding:0 .75rem;">
                                        <option value="0" disabled selected>جستجو بر اساس</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                </div>
                            </div>
                            <div class="form-group row" style="text-align:right;">
                                <div class="col-sm-3" style="padding:.5rem;">
                                    <label>ورودی ها : </label>
                                </div>
                            </div>
                            <div class="form-group row" style="text-align:right;" id="InputDiv"></div>
                            <div class="form-group row" style="text-align:right;">
                                <div class="col-sm-3" style="padding:.5rem;">
                                    <label>خروجی ها : </label>
                                </div>
                            </div>
                            <div class="form-group row" style="text-align:right;" id="OutputDiv"></div>
                        </div>
                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-user btn-block" style="width:25%;margin:auto;">
                            ایجاد گزارش
                        </button>
                        <hr>
                    </form>
                    @endif
                    @endif
                    @if (in_array('4', $sharedData['UserAccessedEntities']))
                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 4)->pluck('rowValue')[0])[4] == 1)
                        <a href="/statisticreports" class="btn btn-outline-secondary btn-user btn-block" style="width:25%;margin:auto;">
                       گزارشات
                        </a>
                        @endif
                    @endif
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
            $("#sltContext").on('change', function ()
            {
                $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                $.ajax(
                    {
                        url: '/customreportcontextchanged/' + $("#sltContext").val(),
                        type: 'post',
                        datatype: 'json',
                        success: function (result) {
                            if (result.HasValue)
                                $("#Partials").html(result.Html);
                            else
                            {
                                $("#sltField").html('');
                                $("#InputDiv").html('');
                                $("#OutputDiv").html('');
                            }
                        },
                        error: function ()
                        {
                            $("#sltField").html('');
                            $("#InputDiv").html('');
                            $("#OutputDiv").html('');
                        }
                    });
            });
            $("#btnSubmit").click(function (e) {
                e.preventDefault();
                if ($("#ReportName").val == "")
                {
                    $("#WarningMessage").text('لطفا نام گزارش را وارد نمایید');
                    $("#warningAlert").removeAttr('hidden');
                    window.setTimeout(function () { $("#warningAlert").attr('hidden', 'hidden'); }, 5000);
                } else {
                var selectedInputs = [];
                var selectedOutputs = [];
                $("input:checkbox").each(function () {
                    if ($(this).is(":checked")) {
                        if ($(this).attr('alt') == 'in')
                        {
                            selectedInputs.push($(this).attr('id'));
                        }
                        if ($(this).attr('alt') == 'out') {
                            selectedOutputs.push($(this).attr('id'));
                        }
                    }
                });
                $.ajax(
                    {
                        url: '/submitaddcustomreport',
                        type: 'post',
                        datatype: 'json',
                        data: { Name: $("#ReportName").val(), ContextId: $("#sltContext").val(), FieldId: $("#sltField").val(), Inputs: selectedInputs, Outputs: selectedOutputs },
                        success: function (result) {
                            if (!result.HasValue) {
                                $("#ErrorMessage").text(result.Message);
                                $("#errorAlert").removeAttr('hidden');
                                window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden') }, 5000);
                            } else {
                                $("#SuccessMessage").text(result.Message);
                                $("#successAlert").removeAttr('hidden');
                                window.setTimeout(function () { $("#successAlert").attr('hidden', 'hidden') }, 5000);
                                $('#AddReportForm').each(function () { this.reset(); });
                            }
                        },
                        error: function () {
                            $("#ErrorMessage").text('خطا در انجام عملیات.لطفا مجدد امتحان کنید');
                            $("#errorAlert").removeAttr('hidden');
                            window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden') }, 5000);
                        }
                    });
                }
            });
        });
        function FieldChange()
        {
            $("input:checkbox").each(function () {
                var currentitem = document.getElementById($(this).attr('id'));
                if ($(this).attr('alt') == 'in') {
                    if ($(this).attr('name') == $("#sltField").val())
                        $(this).prop('checked', true);
                    else
                        $(this).prop('checked', false);
                }
            });
        }
    </script>
    @endsection
@endsection
