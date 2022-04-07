@extends('Layouts.app')

@section('Content')
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">جستجو پیشرفته</h1>
                        </div>
                        <form class="user" id="AdvanceSearchForm">
                            <div class="form-group row">
                                <div class="col-sm-2" style="text-align:right;">
                                    <label style="text-align:right;margin-top:.45rem;">عبارت جستجو</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-user" id="Subject" name="Subject">
                                    <input type="text" class="form-control form-control-user" id="DateSubject"
                                        name="Subject" hidden>
                                </div>
                                <div class="col-sm-2" style="display:flex;">
                                    <input type="checkbox" style="width:1rem;margin:unset !important;" id="cbSimilar"
                                        class="form-control" onclick="$(this).attr('value', this.checked ? '1' : '0')"
                                        value="1" checked />
                                    <label for="cbSimilar" style="margin:.45rem .45rem 0 0">شامل شود</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2" style="text-align:right;">
                                    <label style="text-align:right;margin-top:.45rem;">جستجو در</label>
                                </div>
                                <div class="col-sm-8">
                                    <select class="form-control allWidth" data-ng-style="btn-primary" id="SearchSection"
                                        style="padding:0 .75rem;">
                                        @if (in_array('0', $sharedData['UserAccessedEntities']))
                                            <option value="0" selected>تمامی بخش ها</option>
                                        @endif
                                        @if (in_array('1', $sharedData['UserAccessedEntities']))
                                            <option value="1">محققان</option>
                                        @endif
                                        @if (in_array('2', $sharedData['UserAccessedEntities']))
                                            <option value="2">طرح ها</option>
                                        @endif
                                        @if (in_array('3', $sharedData['UserAccessedEntities']))
                                            <option value="3">کاربران</option>
                                        @endif
                                        @if (in_array('6', $sharedData['UserAccessedEntities']))
                                            <option value="4">اطلاعات پایه</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                </div>
                            </div>
                            <div class="form-group row" id="CascadeSection" hidden>
                                <div class="col-sm-2" style="text-align:right;">
                                    <label style="text-align:right;margin-top:.45rem;" id="lblCascade"></label>
                                </div>
                                <div class="col-sm-8">
                                    <select class="form-control allWidth" data-ng-style="btn-primary" id="SltCascade"
                                        style="padding:0 .75rem;">
                                        <option value="0" selected>تمامی موارد</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2" style="text-align:right;">
                                    <label style="text-align:right;margin-top:.45rem;">جستجو بر اساس</label>
                                </div>
                                <div class="col-sm-8">
                                    <select class="form-control allWidth" data-ng-style="btn-primary" id="SearchBy"
                                        style="padding:0 .75rem;">
                                        <option value="0" selected>تمامی موارد</option>
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                </div>
                                <div class="col-sm-4">
                                    <a href="#" id="btnSearch" class="btn btn-outline-info btn-user btn-block">جستجو</a>
                                </div>
                                <div class="col-sm-4">
                                </div>
                            </div>
                        </form>
                        <p style="font-size:large;text-align: center;color: lightcoral;margin-top: 0.5rem;" id="waitText"
                            hidden>لطفا منتظر بمانید</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow" style="margin-bottom:1rem;">
        <!-- Card Header - Accordion -->
        <a href="#collapseSearchResultItems" style="text-align:right;" class="d-block card-header py-3"
            data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseSearchResultItems">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align:center;">نتیجه جستجو</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" style="padding:.75rem;" id="collapseSearchResultItems">
            <div class="card-body">
                <div class="form-group row" id="ExportDiv" hidden>
                    <button class="btn btn-danger btn-icon-split" style="margin:5px;" id="btnPdfExport">
                        <span class="icon text-white-50">
                            <i class="fas fa-file-pdf"></i>
                        </span>
                        <span class="text">
                            خروجی
                            pdf
                        </span>
                    </button>
                    <button class="btn btn-primary btn-icon-split" style="margin:5px;" onclick="ExportResult(3)">
                        <span class="icon text-white-50">
                            <i class="fas fa-print"></i>
                        </span>
                        <span class="text">
                            پرینت
                        </span>
                    </button>
                    <p style="font-size:large;text-align: center;color: lightcoral;margin-top: 0.5rem;" id="waitText2"
                        hidden>لطفا منتظر بمانید</p>
                </div>
                <div id="Resultwrapper"></div>
            </div>
        </div>
    </div>
    <div class="modal" id="ExportModal" tabindex="-1" role="dialog" aria-labelledby="ExportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ExportModalLabel">خروجی</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="Question" style="margin:0 auto;font-size:xx-large;font-weight:bolder;text-align: right;">
                        بخش های مورد نظر را انتخاب نمایید
                    </p>
                    <div class="col-sm-3" style="display: flex;">
                        <input type="checkbox" style="width:1rem;margin:unset !important;" id="cbProject" name="cbProject"
                            class="form-control" value="true" alt="" checked
                            onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                        <label for="cbProject" style="margin:.45rem .45rem 0 0">طرح</label>
                    </div>
                    <div class="col-sm-3" style="display: flex;">
                        <input type="checkbox" style="width:1rem;margin:unset !important;" id="cbScholar" name="cbScholar"
                            class="form-control" value="true" alt="" checked
                            onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                        <label for="cbScholar" style="margin:.45rem .45rem 0 0">محقق</label>
                    </div>
                    <div class="col-sm-3" style="display: flex;">
                        <input type="checkbox" style="width:1rem;margin:unset !important;" id="cbUser" name="cbUser"
                            class="form-control" value="true" alt="" checked
                            onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                        <label for="cbUser" style="margin:.45rem .45rem 0 0">کاربر</label>
                    </div>
                    <div class="col-sm-3" style="display: flex;">
                        <input type="checkbox" style="width:1rem;margin:unset !important;" id="cbBase" name="cbBase"
                            class="form-control" value="true" alt="" checked
                            onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                        <label for="cbBase" style="margin:.45rem .45rem 0 0">اطلاعات پایه</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-lg-12">
                        <button class="btn btn-success" type="button" style="margin:0 auto;width:15%;"
                            id="btnExportModalSubmit" onclick="ExportResult(1)">خروجی</button>
                        <button class="btn btn-danger" type="button" style="margin:0 0 0 35%;width:15%;"
                            data-dismiss="modal" id="btnCancel">انصراف</button>
                    </div>
                    <input type="text" id="ProjectVal" value="1" name="ProjectVal" hidden>
                    <input type="text" id="ScholarVal" value="1" name="ScholarVal" hidden>
                    <input type="text" id="UserVal" value="1" name="UserVal" hidden>
                    <input type="text" id="BaseVal" value="1" name="BaseVal" hidden>
                </div>
            </div>
        </div>
    </div>
@section('styles')
    <link href="{{ URL('Content/vendor/PersianDate/css/persian-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <title>سامانه مدیریت تحقیقات - جستجو پیشرفته</title>
@endsection
@section('scripts')
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-date.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/PersianDate/js/persian-datepicker.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL('Content/js/demo/datatables-demo.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $("#Subject").focus();
            $("#DateSubject").persianDatepicker({
                altField: '#DateInput',
                altFormat: "YYYY/MM/DD",
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
            $("#DateSubject").on('change', function() {
                if (!
                    /^[1-4]\d{3}\/((0[1-6]\/((3[0-1])|([1-2][0-9])|(0[1-9])))|((1[0-2]|(0[7-9]))\/(30|([1-2][0-9])|(0[1-9]))))$/
                    .test($("#DateSubject").val())) {
                    $("#DateSubject").val('');
                }
            });
            $("#SearchBy").on('change', function() {
                if ((this.value == "6" || this.value == "7" || this.value == "8" || this.value == "9" ||
                        this.value == "10" || this.value == "11" || this.value == "16") && $(
                        "#SearchSection").val() == "2") {
                    $("#Subject").attr('hidden', 'hidden');
                    $("#DateSubject").removeAttr('hidden');
                } else {
                    $("#DateSubject").attr('hidden', 'hidden');
                    $("#Subject").removeAttr('hidden');
                }
            });
            $("#SearchSection").on('change', function() {
                $("#SearchBy").html('');
                $("#DateSubject").attr('hidden', 'hidden');
                $("#Subject").removeAttr('hidden');
                if (this.value == "1" || this.value == "2") {
                    $("#CascadeSection").removeAttr('hidden');
                    $("#SltCascade").find('option').remove();
                    $("#SltCascade").append(new Option("تمامی موارد", "0"));
                    $("#SearchBy").append(new Option("تمامی موارد", "0"));
                    if (this.value == "1") {
                        $("#SltCascade").append(new Option("اطلاعات هویتی", "1"));
                        $("#SltCascade").append(new Option("اطلاعات دانشگاهی", "2"));
                    }
                    if (this.value == "2") {
                        $("#SltCascade").append(new Option("اطلاعات اولیه طرح", "1"));
                        $("#SltCascade").append(new Option("اطلاعات تکمیلی طرح", "2"));
                        $("#SltCascade").append(new Option("اطلاعات دفاعیه طرح", "3"));
                    }
                } else {
                    $("#CascadeSection").attr('hidden', 'hidden');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ URL::to('/') }}' + '/searchsectionchange',
                        type: 'get',
                        datatype: 'json',
                        data: {
                            SectionId: this.value
                        },
                        success: function(result) {
                            if (result.HasValue) {
                                $("#SearchBy").html(result.Html);
                            } else {
                                $("#SearchBy").html(
                                    '<option value="0" selected>تمامی موارد</option> ');
                            }
                        },
                        error: function() {
                            $("#SearchBy").html(
                                '<option value="0" selected>تمامی موارد</option> ');
                        }
                    });
                }
            });
            $("#SltCascade").on('change', function() {
                $("#SearchBy").html('');
                $("#DateSubject").attr('hidden', 'hidden');
                $("#Subject").removeAttr('hidden');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ URL::to('/') }}' + '/searchsectionchange',
                    type: 'get',
                    datatype: 'json',
                    data: {
                        SectionId: $("#SearchSection").val(),
                        cascadeId: this.value
                    },
                    success: function(result) {
                        if (result.HasValue) {
                            $("#SearchBy").html(result.Html);
                        } else {
                            $("#SearchBy option[value='0']").remove();
                            $("#SearchBy").html(
                                '<option value="0" selected>تمامی موارد</option> ');
                        }
                    },
                    error: function() {
                        $("#SearchBy option[value='0']").remove();
                        $("#SearchBy").html('<option value="0" selected>تمامی موارد</option> ');
                    }
                });
            });
            $("#btnSearch").click(function(e) {
                e.preventDefault();
                SearchThis();
            });
            $("#cbProject").change(function() {
                if ($(this).is(':checked')) {
                    $("#ProjectVal").val(1);
                } else {
                    $("#ProjectVal").val(0);
                }
            });
            $("#cbScholar").change(function() {
                if ($(this).is(':checked')) {
                    $("#ScholarVal").val(1);
                } else {
                    $("#ScholarVal").val(0);
                }
            });
            $("#cbUser").change(function() {
                if ($(this).is(':checked')) {
                    $("#UserVal").val(1);
                } else {
                    $("#UserVal").val(0);
                }
            });
            $("#cbBase").change(function() {
                if ($(this).is(':checked')) {
                    $("#BaseVal").val(1);
                } else {
                    $("#BaseVal").val(0);
                }
            });
            $("#btnPdfExport").click(function(e) {
                e.preventDefault();
                $("#ExportModal").modal('show')
            });
        });

        function SearchThis() {
            $("#waitText").removeAttr('hidden')
            $("#Resultwrapper").html("");
            var stext = '';
            if ($("#Subject").is(":hidden"))
                stext = $("#DateSubject").val();
            else
                stext = $("#Subject").val();

            var searchModel = [stext, document.getElementById("SearchSection").value, document.getElementById("SearchBy")
                .value,
                $("#cbSimilar").val()
            ];
            var SearchInp = searchModel.join();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ URL::to('/') }}' + '/submitadvancesearch/' + SearchInp,
                type: 'get',
                datatype: 'json',
                success: function(result) {
                    $("#waitText").attr('hidden', 'hidden');
                    if (result.HasValue)
                    {
                        $("#Resultwrapper").html(result.Html);
                        $("#ExportDiv").removeAttr('hidden')
                    }else
                    {
                        $("#ExportDiv").attr('hidden','hidden')
                    }

                    $("#projectdataTable").dataTable();
                    $("#scholardataTable").dataTable();
                    $("#userdataTable").dataTable();
                    $("#BaseInfodataTable").dataTable();
                },
                error: function() {
                    $("#waitText").attr('hidden', 'hidden');
                    $("#ExportDiv").attr('hidden','hidden')
                }
            });
        }

        function ExportResult(typo) {
            $("#waitText2").removeAttr('hidden')
            switch (typo) {
                case 1:
                    var stext = '';
                    if ($("#Subject").is(":hidden"))
                        stext = $("#DateSubject").val();
                    else
                        stext = $("#Subject").val();

                    var searchModel = [stext, document.getElementById("SearchSection").value, document.getElementById(
                            "SearchBy").value,
                        $("#cbSimilar").val()
                    ];
                    var SearchInp = searchModel.join();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ URL::to('/') }}' + '/downloadadvancesearchresult',
                        type: 'GET',
                        xhrFields: {
                            responseType: 'blob'
                        },
                        data: {
                            searchText: stext,
                            Section: document.getElementById("SearchSection").value,
                            SearchBy: document.getElementById("SearchBy").value,
                            Similar: $("#cbSimilar").val(),
                            ExportOptions: $("#ProjectVal").val() + "," + $("#ScholarVal").val() + "," + $(
                                "#UserVal").val() + "," + $("#BaseVal").val()
                        },
                        success: function(response) {
                            $("#waitText2").attr('hidden', 'hidden');
                            var blob = new Blob([response]);
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = 'نتیجه جستجو.pdf';
                            link.click();
                        },
                        error: function() {
                            $("#waitText2").attr('hidden', 'hidden');
                        }
                    });
                    $("#ExportModal").modal('hide')
                    break;
                case 2:
                    $("#waitText2").attr('hidden', 'hidden');
                    // $("#ScholarDataTable").tableHTMLExport({
                    //     type: 'csv',
                    //     filename: searchResult + '.csv'
                    // });
                    break;
                case 3:
                    var stext = '';
                    if ($("#Subject").is(":hidden"))
                        stext = $("#DateSubject").val();
                    else
                        stext = $("#Subject").val();

                    var searchModel = [stext, document.getElementById("SearchSection").value, document.getElementById(
                            "SearchBy").value,
                        $("#cbSimilar").val()
                    ];
                    var SearchInp = searchModel.join();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ URL::to('/') }}' + '/printadvancesearchresult',
                        type: 'post',
                        datatype: 'json',
                        data: {
                            searchText: stext,
                            Section: document.getElementById("SearchSection").value,
                            SearchBy: document.getElementById("SearchBy").value,
                            Similar: $("#cbSimilar").val()
                        },
                        success: function(result) {
                            $("#waitText2").attr('hidden', 'hidden');
                            if (result.HasValue) {
                                newWin = window.open("");
                                newWin.document.write(result.Html);
                                newWin.print();
                                newWin.close();
                            } else {
                                var divToPrint = document.getElementById("Resultwrapper");
                                newWin = window.open("");
                                newWin.document.write(divToPrint.outerHTML);
                                newWin.print();
                                newWin.close();
                            }
                        },
                        error: function() {
                            $("#waitText2").attr('hidden', 'hidden');
                            var divToPrint = document.getElementById("Resultwrapper");
                            newWin = window.open("");
                            newWin.document.write(divToPrint.outerHTML);
                            newWin.print();
                            newWin.close();
                        }
                    });
                    break;
            }
        }
    </script>
@endsection
@endsection
