@extends('Layouts.app')

@section('Content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align:right;">مدیریت محققان</h6>
        </div>
        <div class="card-body">
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
            <div class="row">
                <div class="col-sm-6 col-md-3 col-lg-2 col-xl-2">
                    @if (in_array('1', $sharedData['UserAccessedEntities']))
                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[0] == 1)
                            <div class="row" style="margin-bottom:1rem;">
                                <a class="btn btn-outline-success btn-block"
                                    href="{{ route('scholar.AddScholar') }}">ایجاد محقق</a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="table-responsive" dir="ltr">
                @if (in_array('1', $sharedData['UserAccessedEntities']))
                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[4] == 1)
                        <table class="table table-bordered" id="dataTable"
                            style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
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
                                @if (in_array('1', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[4] == 1)
                                        @foreach ($Scholar as $sch)
                                            <tr>
                                                <td>{{ $sch->FirstName ?? '' }} {{ $sch->LastName ?? '' }}</td>
                                                <td>{{ $sch->NationalCode ?? '' }}</td>
                                                <td class="priority-1">{{ $sch->Grade ?? '' }}</td>
                                                <td class="priority-2">{{ $sch->MajorName }}</td>
                                                <td class="priority-3">{{ $sch->OreintationName }}</td>
                                                <td class="priority-4">{{ $sch->collegeName ?? '' }}</td>
                                                <td>
                                                    @if (in_array('1', $sharedData['UserAccessedEntities']))
                                                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[1] == 1)
                                                            <a href="{{ route('scholar.EditScholar', $sch->NidScholar) }}"
                                                                style="margin: 2px;width: 110px;"
                                                                class="btn btn-warning btn-icon-split">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </span>
                                                                <span class="text">ویرایش</span>
                                                            </a>
                                                        @endif
                                                    @endif
                                                    @if (in_array('1', $sharedData['UserAccessedEntities']))
                                                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[2] == 1)
                                                            <button class="btn btn-danger btn-icon-split"
                                                                style="margin: 2px;width: 110px;"
                                                                onclick="ShowModal(2,'{{ $sch->NidScholar }}')">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-trash"></i>
                                                                </span>
                                                                <span class="text">&nbsp; &nbsp; حذف</span>
                                                            </button>
                                                        @endif
                                                    @endif
                                                    @if (in_array('1', $sharedData['UserAccessedEntities']))
                                                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[3] == 1)
                                                            <button class="btn btn-info btn-icon-split"
                                                                style="margin: 2px;width: 110px;"
                                                                onclick="ShowModal(1,'{{ $sch->NidScholar }}')">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-info-circle"></i>
                                                                </span>
                                                                <span class="text">جزییات</span>
                                                            </button>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    @endif
                @endif
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
                <p id="DeleteQuestion" style="margin:0 auto;font-size:xx-large;font-weight:bolder;" hidden>آیا برای حذف این
                    محقق اطمینان دارید؟</p>
                <div class="modal-footer">
                    <div class="row" style="margin: 0 auto;">
                        <button class="btn btn-secondary" type="button" id="btnClose" data-dismiss="modal"
                            hidden>بستن</button>
                    </div>
                    <div class="col-lg-12">
                        <button class="btn btn-success" type="button" style="margin:0 auto;width:15%;" id="btnOk"
                            hidden>بلی</button>
                        <button class="btn btn-danger" type="button" style="margin:0 0 0 35%;width:15%;"
                            data-dismiss="modal" id="btnCancel" hidden>خیر</button>
                    </div>
                    <p style="font-size:large;text-align: center;color: lightcoral;margin-top: 0.5rem;margin: 0 auto;" hidden id="waitText">لطفا
                        منتظر بمانید</p>
                </div>
            </div>
        </div>
    </div>
@section('styles')
    <link href="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <title>سامانه مدیریت تحقیقات - مدیریت محققان</title>
@endsection
@section('scripts')
    <script src="{{ URL('Content/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL('Content/js/demo/datatables-demo.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            // var successedit = '@TempData["EditScholarSuccessMessage"]';
            // var erroredit = '@TempData["EditScholarErrorMessage"]';
            // var successdelete = '@TempData["DeleteScholarSuccessMessage"]';
            if (successedit != '') {
                $("#SuccessMessage").text(successedit);
                $("#successAlert").removeAttr('hidden')
                window.setTimeout(function() {
                    $("#successAlert").attr('hidden', 'hidden');
                }, 10000);
            }
            if (erroredit != '') {
                $("#ErrorMessage").text(erroredit);
                $("#errorAlert").removeAttr('hidden')
                window.setTimeout(function() {
                    $("#errorAlert").attr('hidden', 'hidden');
                }, 10000);
            }
            if (successdelete != '') {
                $("#SuccessMessage").text(successdelete);
                $("#successAlert").removeAttr('hidden')
                window.setTimeout(function() {
                    $("#successAlert").attr('hidden', 'hidden');
                }, 10000);
            }
        });

        function ShowModal(typo, NidScholar) {
            if (typo == 1) {
                $("#ScholarModalLabel").text('جزییات اطلاعات محقق');
                $("#btnClose").removeAttr('hidden');
                $("#btnCancel").attr('hidden', 'hidden');
                $("#btnOk").attr('hidden', 'hidden');
                $("#DeleteQuestion").attr('hidden', 'hidden');
                $.ajax({
                    url: '/scholardetail/' + NidScholar,
                    type: 'get',
                    datatype: 'json',
                    success: function(result) {
                        if (result.HasValue) {
                            $("#ScholarModalBody").html(result.Html)
                            $("#ScholarModal").modal('show')
                        }
                    },
                    error: function() {}
                })
            } else if (typo == 2) {
                $("#ScholarModalLabel").text('حذف محقق');
                $("#DeleteQuestion").removeAttr('hidden');
                $("#btnOk").removeAttr('hidden');
                $("#btnCancel").removeAttr('hidden');
                $("#btnClose").attr('hidden', 'hidden');
                $("#btnOk").attr('onclick', 'DeleteScholar(' + "'" + NidScholar + "'" + ')');
            }
            $.ajax({
                url: '/scholardetail/' + NidScholar,
                type: 'get',
                datatype: 'json',
                success: function(result) {
                    if (result.HasValue) {
                        $("#ScholarModalBody").html(result.Html)
                        $("#ScholarModal").modal('show')
                    }
                },
                error: function() {}
            })
        }

        function DeleteScholar(NidScholar) {
            $("#waitText").removeAttr('hidden');
            $.ajax({
                url: '/deletescholar/' + NidScholar, //'@Url.Action("DeleteScholar","Home")',
                type: 'get',
                datatype: 'json',
                success: function(result) {
                    $("#waitText").attr('hidden', 'hidden');
                    if (result.Message == "1")
                        window.location.reload()
                    else if (result.Message == "2") {
                        $("#ScholarModal").modal('hide');
                        $("#ErrorMessage").text(result.Html);
                        $("#errorAlert").removeAttr('hidden');
                        window.setTimeout(function() {
                            $("#errorAlert").attr('hidden', 'hidden');
                        }, 10000);

                    } else if (result.Message == "3") {
                        $("#ScholarModal").modal('hide');
                        $("#WarningMessage").text(result.Html);
                        $("#warningAlert").removeAttr('hidden');
                        window.setTimeout(function() {
                            $("#warningAlert").attr('hidden', 'hidden');
                        }, 10000);
                    }
                },
                error: function() {
                    $("#waitText").attr('hidden', 'hidden');
                }
            });
        }
    </script>
@endsection
@endsection
