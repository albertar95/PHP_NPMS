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
                        <p style="font-size:large;text-align: center;color: lightcoral;margin-top: 0.5rem;" id="waitText" hidden>لطفا منتظر بمانید</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow" style="margin-bottom:1rem;">
        <!-- Card Header - Accordion -->
        <a href="#collapseSearchResultItems" style="text-align:right;" class="d-block card-header py-3" data-toggle="collapse" role="button"
            aria-expanded="true" aria-controls="collapseSearchResultItems">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align:center;">نتیجه جستجو</h6>
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
                        url: '/searchsectionchange',
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
                    url: '/searchsectionchange',
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
                url: '/submitadvancesearch/' + SearchInp,
                type: 'get',
                datatype: 'json',
                success: function(result) {
                    $("#waitText").attr('hidden', 'hidden');
                    if (result.HasValue)
                        $("#Resultwrapper").html(result.Html);
                        $("#projectdataTable").dataTable();
                        $("#scholardataTable").dataTable();
                        $("#userdataTable").dataTable();
                        $("#BaseInfodataTable").dataTable();
                },
                error: function()
                {
                    $("#waitText").attr('hidden', 'hidden');
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
                        url: '/downloadadvancesearchresult',
                        type: 'post',
                        datatype: 'json',
                        data: {
                            searchText: stext,
                            Section: document.getElementById("SearchSection").value,
                            SearchBy: document.getElementById("SearchBy").value,
                            Similar: $("#cbSimilar").val()
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
                        url: '/printadvancesearchresult',
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
