@extends('Layouts.app')

@section('Content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align:right;">کاربران نقش : {{ $RoleName }}</h6>
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
            <div class="row" style="margin-bottom:1rem;">
                @if (in_array('0', $sharedData['UserAccessedEntities']))
                <div class="col-sm-3">
                </div>
                <div class="col-sm-6"></div>
                <div class="col-sm-3">
                    <a id="btnReturn" class="btn btn-outline-info btn-block" style="direction: ltr;"
                        href="/manageroles">&larr; بازگشت</a>
                </div>
                @endif
            </div>
            <div class="table-responsive" dir="ltr" id="tableWrapper">
                <table class="table table-bordered" id="dataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                    <thead>
                        <tr>
                            <th>مشخصات کاربر</th>
                            <th>نام کاربری</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>مشخصات کاربر</th>
                            <th>نام کاربری</th>
                            <th>عملیات</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($Users as $user)
                            <tr>
                                <td>{{ $user->FirstName }} {{ $user->LastName }}</td>
                                <td>{{ $user->Username }}</td>
                                <td>
                                    <a href="/manageuserpermission/{{ $user->NidUser }}" class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-door-open"></i>
                                        </span>
                                        <span class="text">اعمال دسترسی</span>
                                    </a>
                                </td>
                            </tr>
                          @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @section('styles')
        <link href="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
        <title>سامانه مدیریت تحقیقات - کاربران نقش</title>
    @endsection
    @section('scripts')
        <script src="{{ URL('Content/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ URL('Content/js/demo/datatables-demo.js') }}"></script>
    @endsection

@endsection
