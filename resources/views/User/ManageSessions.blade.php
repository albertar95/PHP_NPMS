@extends('Layouts.app')

@section('Content')
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">تنظیمات</h1>
                        </div>
                        @if (in_array('0', $sharedData['UserAccessedEntities']))
                            <form class="user" id="SessionSettingForm"
                                action="{{ route('user.SubmitSessionSetting') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label>مدت زمان پایان نشست کاربر : </label>
                                    </div>
                                    <div class="col-sm-2">
                                        @if ($sets->count() > 0)
                                            <input type="text" class="form-control form-control-user" id="SessionTimeout"
                                                name="SessionTimeout" placeholder=""
                                                value="{{ $sets->where('SettingKey', '=', 'SessionTimeout')->firstOrFail()->SettingValue ?? config('session.lifetime') }}">
                                        @else
                                            <input type="text" class="form-control form-control-user" id="SessionTimeout"
                                                name="SessionTimeout" placeholder=""
                                                value="{{ config('session.lifetime') }}">
                                        @endforelse
                                    </div>
                                </div>
                                <button type="submit" id="btnSubmit" class="btn btn-primary btn-user btn-block"
                                    style="width:25%;margin:auto;margin-top: 3rem;">
                                    ذخیره اطلاعات
                                </button>
                                <hr />
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
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
                        <div class="table-responsive" dir="ltr" id="tableWrapper">
                            @if (in_array('3', $sharedData['UserAccessedEntities']))
                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 3)->pluck('rowValue')[0])[4] == 1)
                                    <table class="table table-bordered" id="dataTable"
                                        style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>تصویر</th>
                                                <th>مشخصات کاربر</th>
                                                <th>نام کاربری</th>
                                                <th>وضعیت</th>
                                                <th>عملیات</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>تصویر</th>
                                                <th>مشخصات کاربر</th>
                                                <th>نام کاربری</th>
                                                <th>وضعیت</th>
                                                <th>عملیات</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($users as $usr)
                                                <tr>
                                                    <td>
                                                        @if (!empty($usr->ProfilePicture))
                                                            <img src="/storage/images/{{ $usr->ProfilePicture }}"
                                                                height="50" width="50" />
                                                        @else
                                                            <img height="50" width="50"
                                                                src="{{ URL('Content/img/User/user3.png') }}">
                                                        @endforelse
                                                    </td>
                                                    <td>{{ $usr->FirstName }} {{ $usr->LastName }}</td>
                                                    <td>{{ $usr->Username }}</td>
                                                    <td>
                                                        @if (Cache::has('user-is-online-' . $usr->NidUser))
                                                            <span class="badge badge-success">آنلاین</span>
                                                        @else
                                                            <span class="badge badge-danger">آفلاین</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (Cache::has('user-is-online-' . $usr->NidUser))
                                                            <button class="btn btn-danger"
                                                                onclick="ShowModal('{{ $usr->NidUser }}')">خروج</button>
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
                <p id="DeleteQuestion" style="margin:0 auto;font-size:xx-large;font-weight:bolder;">آیا برای خروج
                    نمودن این کاربر اطمینان دارید؟</p>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" style="margin:0 auto;width:15%;" id="btnOk">بلی</button>
                    <button class="btn btn-danger" type="button" style="margin:0 0 0 35%;width:15%;" data-dismiss="modal"
                        id="btnCancel">خیر</button>
                </div>
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
            $("#btnOk").attr('onclick', 'LogoutUser(' + "'" + NidUser + "'" + ')');
            $("#UserModal").modal('show')
        }

        function LogoutUser(NidUser) {
            $.ajax({
                url: '/logoutuser/' + NidUser,
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
    </script>
@endsection
@endsection
