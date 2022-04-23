@extends('Layouts.app')

@section('Content')
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row" style="text-align: right;">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">تنظیمات</h1>
                        </div>
                        @if (in_array('0', $sharedData['UserAccessedEntities']))
                            <form class="user" id="BackupSettingForm"
                                action="{{ route('user.SubmitBackupPath') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6" style="display: flex;">
                                        <label>مسیر پشتیبان گیری : </label>
                                        <input type="text" dir="ltr" class="form-control form-control-user" id="BackupPath"
                                        name="BackupPath" placeholder=""
                                        value="{{ config('filesystems.disks.alter.root') }}">
                                        {{-- @if ($sets->count() > 0)
                                        <input type="text" class="form-control form-control-user" id="BackupPath"
                                            name="BackupPath" placeholder=""
                                            value="{{ $sets->where('SettingKey', '=', 'BackupPath')->firstOrFail()->SettingValue ?? config('filesystems.disks.alter.root') }}">
                                    @else
                                        <input type="text" dir="ltr" class="form-control form-control-user" id="BackupPath"
                                            name="BackupPath" placeholder=""
                                            value="{{ config('filesystems.disks.alter.root') }}">
                                    @endforelse --}}
                                    </div>
                                    {{-- <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    </div> --}}
                                    <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3">
                                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-user btn-block">
                                            ذخیره اطلاعات
                                        </button>
                                    </div>
                                </div>
                                <hr />
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">سوابق پشتیبان گیری</h1>
                        </div>
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
                            <table class="table table-bordered" id="dataTable"
                            style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>تاریخ</th>
                                    <th>مسیر</th>
                                    <th>حجم فایل</th>
                                    <th>مدت زمان (دقیقه)</th>
                                    <th>وضعیت</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>تاریخ</th>
                                    <th>مسیر</th>
                                    <th>حجم فایل</th>
                                    <th>مدت زمان (دقیقه)</th>
                                    <th>وضعیت</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach ($backuplogs as $lg)
                                    <tr>
                                        <td dir="ltr">{{ $lg->CreateDate }}</td>
                                        <td dir="ltr">{{ $lg->Path }}</td>
                                        <td dir="ltr">
                                            {{ $lg->Size }}
                                        </td>
                                        <td>
                                            {{ $lg->Duration }}
                                        </td>
                                        <td>
                                            @if ($lg->BackupStatus)
                                                <span class="badge badge-success">موفق</span>
                                            @else
                                                <span class="badge badge-danger">ناموفق</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                <p id="DeleteQuestion" style="margin:0 auto;font-size:xx-large;font-weight:bolder;">آیا برای خارج
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
    <title>سامانه مدیریت تحقیقات - مدیریت پشتیبان گیری</title>
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
                url: '{{URL::to('/')}}' + '/logoutuser/' + NidUser,
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
