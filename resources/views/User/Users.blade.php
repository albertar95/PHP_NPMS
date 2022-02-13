@extends('Layouts.app')

@section('Content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align:right;">مدیریت کاربران</h6>
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
            <div class="row" style="margin-bottom:1rem;">
                @if(in_array('3',$sharedData['UserAccessedEntities']))
                    @if(explode(',',$sharedData['UserAccessedSub']->where('entity','=',3)->pluck('rowValue')[0])[0] == 1)
                    <div class="col-sm-3">
                    <a class="btn btn-outline-success btn-block" href="{{ route('user.AddUser') }}">ایجاد کاربر</a>
                </div>
                    @endif
                @endif
                <div class="col-sm-3">
                <a id="btnDisabled" onclick="ChangeTableSource(1)" class="btn btn-outline-danger btn-block" href="#">کاربران غیرفعال</a>
                </div>
                <div class="col-sm-3">
                <a id="btnLockout" onclick="ChangeTableSource(2)" class="btn btn-outline-warning btn-block" href="#">کاربران تعلیق شده</a>
                </div>
                <div class="col-sm-3">
                <a id="btnDefault" onclick="ChangeTableSource(5)" class="btn btn-outline-secondary btn-block" href="#">حالت پیش فرض</a>
                </div>
            </div>
            <div class="table-responsive" dir="ltr" id="tableWrapper">
            @if(in_array('3',$sharedData['UserAccessedEntities']))
                @if(explode(',',$sharedData['UserAccessedSub']->where('entity','=',3)->pluck('rowValue')[0])[4] == 1)
                <table class="table table-bordered" id="dataTable" style="width:100%;direction:rtl;text-align:center;"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th>تصویر</th>
                            <th>مشخصات کاربر</th>
                            <th>نام کاربری</th>
                            <th>نقش</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>تصویر</th>
                            <th>مشخصات کاربر</th>
                            <th>نام کاربری</th>
                            <th>نقش</th>
                            <th>عملیات</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($Users as $usr)
                            <tr>
                                <td>
                                    @if (!empty($usr->ProfilePicture))
                                        <img src="/storage/images/{{ $usr->ProfilePicture }}" height="50" width="50" />
                                    @else
                                        <img height="50" width="50" src="{{ URL('Content/img/User/user3.png') }}">
                                    @endforelse
                                </td>
                                <td>{{ $usr->FirstName }} {{ $usr->LastName }}</td>
                                <td>{{ $usr->Username }}</td>
                                <td>{{ $usr->RoleTitle }}</td>
                                <td>
                                @if(in_array('3',$sharedData['UserAccessedEntities']))
                                    @if(explode(',',$sharedData['UserAccessedSub']->where('entity','=',3)->pluck('rowValue')[0])[3] == 1)
                                    <button class="btn btn-info btn-icon-split" style="margin: 2px;width: 110px;"
                                    onclick="ShowModal(1,'{{ $usr->NidUser }}')">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-info-circle"></i>
                                    </span>
                                    <span class="text">جزییات</span>
                                </button>
                                    @endif
                                @endif
                                @if(in_array('3',$sharedData['UserAccessedEntities']))
                                    @if(explode(',',$sharedData['UserAccessedSub']->where('entity','=',3)->pluck('rowValue')[0])[1] == 1)
                                    <a href="edituser/{{ $usr->NidUser }}" class="btn btn-warning btn-icon-split" style="margin: 2px;width: 110px;" >
                                        <span class="icon text-white-50">
                                            <i class="fas fa-pencil-alt"></i>
                                        </span>
                                        <span class="text">ویرایش</span>
                                    </a>
                                    @endif
                                @endif
                                @if(in_array('3',$sharedData['UserAccessedEntities']))
                                    @if(explode(',',$sharedData['UserAccessedSub']->where('entity','=',3)->pluck('rowValue')[0])[2] == 1)
                                    <button class="btn btn-danger btn-icon-split" style="margin: 2px;width: 110px;"
                                    onclick="ShowModal(2,'{{ $usr->NidUser }}')">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    <span class="text">غیرفعال</span>
                                </button>
                                    @endif
                                @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                @endif
            </div>
        </div>
    </div>
    <div class="modal" id="UserModal" tabindex="-1" role="dialog" aria-labelledby="UserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="UserModalLabel"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="UserModalBody">
                </div>
                <p id="DeleteQuestion" style="margin:0 auto;font-size:xx-large;font-weight:bolder;" hidden>آیا برای غیرفعال
                    نمودن این کاربر اطمینان دارید؟</p>
                <div class="modal-footer">
                    <div class="row" style="margin: 0 auto;">
                        <button class="btn btn-secondary" type="button" id="btnClose" data-dismiss="modal" hidden>بستن</button>
                        </div>
                    <div class="col-lg-12">
                        <button class="btn btn-success" type="button" style="margin:0 auto;width:15%;" id="btnOk"
                            hidden>بلی</button>
                        <button class="btn btn-danger" type="button" style="margin:0 0 0 35%;width:15%;"
                            data-dismiss="modal" id="btnCancel" hidden>خیر</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('styles')
    <link href="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <title>سامانه مدیریت تحقیقات - مدیریت کاربران</title>
@endsection
@section('scripts')
    <script src="{{ URL('Content/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL('Content/js/demo/datatables-demo.js') }}"></script>
    <script type="text/javascript">
        function ShowModal(typo, NidUser) {
            if (typo == 1) {
                $("#UserModalLabel").text('جزییات اطلاعات کاربر');
                $("#btnClose").removeAttr('hidden');
                $("#btnCancel").attr('hidden', 'hidden');
                $("#btnOk").attr('hidden', 'hidden');
                $("#DeleteQuestion").attr('hidden', 'hidden');
            } else if (typo == 2) {
                $("#UserModalLabel").text('غیرفعال کردن کاربر');
                $("#DeleteQuestion").removeAttr('hidden');
                $("#btnOk").removeAttr('hidden');
                $("#btnCancel").removeAttr('hidden');
                $("#btnClose").attr('hidden', 'hidden');
                $("#btnOk").attr('onclick', 'DisableUser(' + "'" + NidUser + "'" + ')');
            }
            $.ajax({
                url: '/userdetail/' + NidUser,
                type: 'get',
                datatype: 'json',
                success: function(result) {
                    if (result.HasValue) {
                        $("#UserModalBody").html(result.Html)
                        $("#UserModal").modal('show')
                    }
                },
                error: function() {}
            })
        }

        function DisableUser(NidUser) {
            $.ajax({
                url: '/disableuser/' + NidUser,
                type: 'get',
                datatype: 'json',
                success: function(result) {
                    if (result.HasValue)
                        window.location.reload()
                    else {
                        $("#UserModal").modal('hide');
                        $("#ErrorMessage").text(result.Message);
                        $("#errorAlert").removeAttr('hidden');
                        window.setTimeout(function() {
                            $("#errorAlert").attr('hidden', 'hidden');
                        }, 10000);

                    }
                },
                error: function() {}
            });
        }

        function ChangeTableSource(sourceId) {
            $.ajax({
                url: '/usersourcechange/' + sourceId,
                type: 'get',
                datatype: 'json',
                success: function(result) {
                    $("#dataTable").html(result.Html)
                },
                error: function() {}
            });
        }
    </script>
@endsection


@endsection
