@extends('Layouts.app')

@section('Content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align:right;">مدیریت دسترسی نقش ها</h6>
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
                <a class="btn btn-outline-success btn-block" style="margin:.25rem;width:15%;"
                    href="{{ route('user.AddRolePermission') }}">ایجاد دسترسی</a>
            </div>
            <div class="table-responsive" dir="ltr" id="tableWrapper">
                <table class="table table-bordered" id="dataTable" style="width:100%;direction:rtl;text-align:center;"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th>نام نقش</th>
                            <th>نام موجودیت</th>
                            <th>دسترسی ایجاد</th>
                            <th>دسترسی ویرایش</th>
                            <th>دسترسی حذف</th>
                            <th>دسترسی جزییات</th>
                            <th>دسترسی لیست</th>
                            <th>دسترسی چاپ</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>نام نقش</th>
                            <th>نام موجودیت</th>
                            <th>دسترسی ایجاد</th>
                            <th>دسترسی ویرایش</th>
                            <th>دسترسی حذف</th>
                            <th>دسترسی جزییات</th>
                            <th>دسترسی لیست</th>
                            <th>دسترسی چاپ</th>
                            <th>عملیات</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($Permissions as $perm)
                            <tr>
                                <td>{{ $perm->RoleTitle }}</td>
                                @if($perm->EntityId == 1)
                                <td>محقق</td>
                                @elseif($perm->EntityId == 2)
                                <td>پروژه</td>
                                @elseif($perm->EntityId == 3)
                                <td>کاربر</td>
                                @elseif($perm->EntityId == 4)
                                <td>گزارش</td>
                                @elseif($perm->EntityId == 5)
                                <td>پیام</td>
                                @endforelse
                                @if ($perm->Create)
                                    <td>دارد</td>
                                @else
                                    <td>ندارد</td>
                                @endforelse
                                @if ($perm->Edit)
                                    <td>دارد</td>
                                @else
                                    <td>ندارد</td>
                                @endforelse
                                @if ($perm->Delete)
                                    <td>دارد</td>
                                @else
                                    <td>ندارد</td>
                                @endforelse
                                @if ($perm->Detail)
                                    <td>دارد</td>
                                @else
                                    <td>ندارد</td>
                                @endforelse
                                @if ($perm->List)
                                    <td>دارد</td>
                                @else
                                    <td>ندارد</td>
                                @endforelse
                                @if ($perm->Print)
                                    <td>دارد</td>
                                @else
                                    <td>ندارد</td>
                                @endforelse
                                <td>
                                    <a href="editrolepermission/{{ $perm->NidPermission }}"
                                        class="btn btn-warning">ویرایش</a>
                                    <button class="btn btn-danger"
                                        onclick="ShowModal('{{ $perm->NidPermission }}')">حذف</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal" id="DeleteModal" tabindex="-1" role="dialog" aria-labelledby="DeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DeleteModalLabel"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="DeleteModalBody">
                    <p id="DeleteQuestion" style="margin:0 auto;font-size:xx-large;font-weight:bolder;text-align: right;">
                        آیا برای حذف دسترسی اطمینان دارید؟
                    </p>
                </div>
                <div class="modal-footer">
                    <div class="col-lg-12">
                        <button class="btn btn-success" type="button" style="margin:0 auto;width:15%;"
                            id="btnOk">بلی</button>
                        <button class="btn btn-danger" type="button" style="margin:0 0 0 35%;width:15%;"
                            data-dismiss="modal" id="btnCancel">خیر</button>
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
        var NidPerm = "";
        $(function() {
            $("#btnOk").click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/deleterolepermission/' + NidPerm,
                    type: 'post',
                    datatype: 'json',
                    success: function(result) {
                        if (result.HasValue)
                            window.location.reload()
                        else {
                            $("#DeleteModal").modal('hide');
                            $("#ErrorMessage").text(result.Message);
                            $("#errorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#errorAlert").attr('hidden', 'hidden');
                            }, 10000);
                        }
                    },
                    error: function() {}
                });
            });
        });

        function ShowModal(NidPermission) {
            NidPerm = NidPermission;
            $("#DeleteModal").modal('show')
        }
    </script>
@endsection


@endsection
