@extends('Layouts.app')

@section('Content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align:right;">مدیریت دسترسی ها</h6>
        </div>
        <div class="card-body">
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
            <div class="table-responsive" dir="ltr" id="tableWrapper">
                <table class="table table-bordered" id="dataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                    <thead>
                        <tr>
                            <th>مشخصات کاربر</th>
                            <th>نام کاربری</th>
                            <th>سطح کاربری</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>مشخصات کاربر</th>
                            <th>نام کاربری</th>
                            <th>سطح کاربری</th>
                            <th>عملیات</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($Users as $user)
                            <tr>
                                <td>{{ $user->FirstName }} {{ $user->LastName }}</td>
                                <td>{{ $user->Username }}</td>
                                @if ($user->IsAdmin == false)
                                    <td>کاربر عادی</td>
                                @else
                                    <td>کاربر ادمین</td>
                                @endforelse
                                <td>
                                    <a href="managepermission/{{ $user->NidUser }}" class="btn btn-info">اعمال دسترسی</a>
                                    <button class="btn btn-secondary" onclick="ShowModal('{{ $user->NidUser }}')">جزییات</button>
                                </td>
                            </tr>
                          @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal" id="UserPermissionModal" tabindex="-1" role="dialog" aria-labelledby="UserPermissionLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="UserPermissionLabel">دسترسی های کاربر</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="UserPermissionModalBody">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" id="btnClose" data-dismiss="modal" style="margin:0 auto;width:10%;">بستن</button>
                </div>
            </div>
        </div>
    </div>
    @section('styles')
        <link href="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @endsection
    @section('scripts')
        <script src="{{ URL('Content/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ URL('Content/js/demo/datatables-demo.js') }}"></script>
        <script type="text/javascript">
            function ShowModal(NidUser) {
                $.ajax(
                    {
                        url: '/userpermissiondetail/' + NidUser,
                        type: 'get',
                        datatype: 'json',
                        success: function (result) {
                            if (result.HasValue) {
                                $("#UserPermissionModalBody").html(result.Html)
                                $("#UserPermissionModal").modal('show')
                            }
                        },
                        error: function () { }
                    })
            }
        </script>
    @endsection

@endsection
