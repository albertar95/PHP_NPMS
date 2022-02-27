@extends('Layouts.app')

@section('Content')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align:right;">مدیریت دسترسی نقش ها</h6>
        </div>
        <div class="card-body">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">نقش {{ $RoleName }}</h1>
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
            <div class="row" style="margin-bottom:1rem;">
                @if (in_array('0', $sharedData['UserAccessedEntities']))
                <div class="col-sm-3">
                    <a class="btn btn-outline-success btn-block" href="{{ sprintf("%s/%s",URL::to('/addrolepermission'),$RoleId) }}">ایجاد دسترسی</a>
                </div>
                <div class="col-sm-6"></div>
                <div class="col-sm-3">
                    <a id="btnReturn" class="btn btn-outline-info btn-block" style="direction: ltr;"
                        href="{{ URL::to('/manageroles') }}">&larr; بازگشت</a>
                </div>
                @endif
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
                            <th>دسترسی محرمانه</th>
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
                            <th>دسترسی محرمانه</th>
                            <th>دسترسی لیست</th>
                            <th>دسترسی چاپ</th>
                            <th>عملیات</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @if (in_array('0', $sharedData['UserAccessedEntities']))
                            @foreach ($Permissions as $perm)
                                <tr>
                                    <td>{{ $perm->RoleTitle }}</td>
                                    @if ($perm->EntityId == 1)
                                        <td>محقق</td>
                                    @elseif($perm->EntityId == 2)
                                        <td>پروژه</td>
                                    @elseif($perm->EntityId == 3)
                                        <td>کاربر</td>
                                    @elseif($perm->EntityId == 4)
                                        <td>گزارش</td>
                                    @elseif($perm->EntityId == 5)
                                        <td>پیام</td>
                                    @elseif($perm->EntityId == 6)
                                        <td>اطلاعات پایه</td>
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
                                    @if ($perm->Confident)
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
                                        @if (in_array('0', $sharedData['UserAccessedEntities']))
                                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 0)->pluck('rowValue')[0])[1] == 1)
                                                <a href="{{ sprintf("%s/%s",URL::to('/editrolepermission'),$perm->NidPermission) }}"
                                                    class="btn btn-warning btn-icon-split" style="margin: 2px;width: 110px;">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </span>
                                                    <span class="text">ویرایش</span>
                                                </a>
                                            @endif
                                        @endif
                                        @if (in_array('0', $sharedData['UserAccessedEntities']))
                                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 0)->pluck('rowValue')[0])[2] == 1)
                                                <button class="btn btn-danger btn-icon-split" style="margin: 2px;width: 110px;"
                                                    onclick="ShowModal('{{ $perm->NidPermission }}')">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                    <span class="text">&nbsp; &nbsp; حذف</span>
                                                </button>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
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
                    <p style="font-size:large;text-align: center;color: lightcoral;margin-top: 0.5rem;margin: 0 auto;" id="waitText" hidden>لطفا منتظر بمانید</p>
                </div>
            </div>
        </div>
    </div>
@section('styles')
    <link href="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <title>سامانه مدیریت تحقیقات - دسترسی نقش</title>
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
                $("#waitText").attr('hidden', 'hidden');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{URL::to('/')}}' + '/deleterolepermission/' + NidPerm,
                    type: 'post',
                    datatype: 'json',
                    success: function(result) {
                        $("#waitText").attr('hidden', 'hidden');
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
                    error: function()
                    {
                        $("#waitText").attr('hidden', 'hidden');
                    }
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
