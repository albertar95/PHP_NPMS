@extends('Layouts.app')

@section('Content')
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">مدیریت نقش ها</h1>
                        </div>
                        <div class="alert alert-success alert-dismissible" role="alert" id="RoleSuccessAlert" hidden>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <p style="text-align:right;" id="RoleSuccessMessage"></p>
                        </div>
                        <div class="alert alert-warning alert-dismissible" role="alert" id="RoleWarningAlert" hidden>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <p style="text-align:right;" id="RoleWarningMessage"></p>
                        </div>
                        <div class="alert alert-danger alert-dismissible" role="alert" id="RoleErrorAlert" hidden>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <p style="text-align:right;" id="RoleErrorMessage"></p>
                        </div>
                        <form class="user" id="RolesForm" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-sm-2 mb-3 mb-sm-0">
                                    <input type="text" value="" id="NidRole" name="NidRole" hidden />
                                    <input type="datetime" value="" id="CreateDate" name="CreateDate" hidden />
                                    <input type="text" class="form-control form-control-user" id="Title" name="Title"
                                        placeholder="عنوان نقش">
                                </div>
                                <div class="col-sm-2" style="display: flex;">
                                    <input type="checkbox" style="width:1rem;margin:unset !important;" id="IsAdmin"
                                        name="IsAdmin" class="form-control" alt=""
                                        onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                    <label for="IsAdmin" style="margin:.45rem .45rem 0 0">نقش مدیر باشد؟</label>
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-primary btn-user btn-block" type="submit" id="btnAddRole">
                                        ایجاد نقش
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive" dir="ltr" id="RoleTableWrapper">
                            <table class="table table-bordered" id="RoledataTable"
                                style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>عنوان نقش</th>
                                        <th>سطح نقش</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>عنوان نقش</th>
                                        <th>سطح نقش</th>
                                        <th>عملیات</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @if (in_array('0', $sharedData['UserAccessedEntities']))
                                        @foreach ($Roles as $key => $role)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $role->Title }}</td>
                                                @if ($role->IsAdmin)
                                                    <td>نقش مدیر</td>
                                                @else
                                                    <td>نقش عادی</td>
                                                @endforelse
                                                <td>
                                                    @if (in_array('0', $sharedData['UserAccessedEntities']))
                                                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 0)->pluck('rowValue')[0])[2] == 1)
                                                            <button class="btn btn-danger btn-icon-split" style="margin: 2px;"
                                                                onclick="DeleteModal(1,'{{ $role->NidRole }}')">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-trash"></i>
                                                                </span>
                                                                <span class="text">حذف</span>
                                                            </button>
                                                        @endif
                                                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 0)->pluck('rowValue')[0])[1] == 1)
                                                            <button class="btn btn-warning btn-icon-split" style="margin: 2px;"
                                                                onclick="EditThis('{{ $role->NidRole }}','{{ $role->Title }}','{{ $role->CreateDate }}','{{ $role->IsAdmin }}')">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-pencil-alt"></i>
                                                                </span>
                                                                <span class="text">ویرایش</span>
                                                            </button>
                                                        @endif
                                                        <a href="/managerolepermissions/{{ $role->NidRole }}" style="margin: 2px;"
                                                            class="btn btn-info btn-icon-split">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-door-open"></i>
                                                            </span>
                                                            <span class="text">اعمال دسترسی</span>
                                                        </a>
                                                        <a href="/managerolesuser/{{ $role->NidRole }}" style="margin: 2px;"
                                                            class="btn btn-secondary btn-icon-split">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-user"></i>
                                                            </span>
                                                            <span class="text">کاربران</span>
                                                        </a>
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
            </div>
        </div>
    </div>
    <div class="modal" id="DeleteItemModal" tabindex="-1" role="dialog" aria-labelledby="DeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DeleteModalLabel">حذف نقش</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="DeleteQuestion" style="margin:0 auto;font-size:xx-large;font-weight:bolder;text-align: right;">
                        آیا برای حذف این نقش اطمینان دارید ؟
                    </p>
                </div>
                <div class="modal-footer">
                    <div class="col-lg-12">
                        <button class="btn btn-success" type="button" style="margin:0 auto;width:15%;"
                            id="btnDeleteModalSubmit">بلی</button>
                        <button class="btn btn-danger" type="button" style="margin:0 0 0 35%;width:15%;"
                            data-dismiss="modal" id="btnCancel">خیر</button>
                    </div>
                    <p style="font-size:large;text-align: center;color: lightcoral;margin-top: 0.5rem;margin: 0 auto;" id="waitText" hidden>لطفا منتظر بمانید</p>
                    <input type="text" id="CurrentDeleteNid" value="" hidden />
                    <input type="text" id="CurrentDeleteTypo" value="" hidden />
                </div>
            </div>
        </div>
    </div>
@section('styles')
<title>سامانه مدیریت تحقیقات - مدیریت نقش ها</title>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(function() {
            $("#btnAddRole").click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '/submitroleform',
                    type: 'post',
                    datatype: 'json',
                    data: $("#RolesForm").serialize(),
                    success: function(result) {
                        if (result.HasValue) {
                            $("#RoleTableWrapper").html(result.Html);
                            $("#RolesForm").each(function() {
                                this.reset();
                            });
                            $("#RoleSuccessMessage").text(result.Message);
                            $("#RoleSuccessAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#RoleSuccessAlert").attr('hidden', 'hidden');
                            }, 3000);
                            $("#btnAddRole").html('ایجاد نقش');
                            $("#btnAddRole").removeClass('btn-warning');
                            $("#btnAddRole").addClass('btn-primary');
                        } else {
                            $("#UnitErrorMessage").text(result.Message);
                            $("#UnitErrorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#UnitErrorAlert").attr('hidden', 'hidden');
                            }, 3000);
                        }
                    },
                    error: function() {
                        $("#UnitErrorMessage").text('خطا در سرور.لطفا مجددا امتحان کنید');
                        $("#UnitErrorAlert").removeAttr('hidden');
                        window.setTimeout(function() {
                            $("#UnitErrorAlert").attr('hidden', 'hidden');
                        }, 3000);
                    }
                });
            });
        });
    </script>
    <!--Form Submit Part-->
    <script type="text/javascript">
        function EditThis(Nid, Title, Createdate, IsAdmin) {
            $("#NidRole").val(Nid);
            $("#Title").val(Title);
            $("#IsAdmin").val(IsAdmin);
            if (IsAdmin == 1) {
                $('#IsAdmin').prop('checked', true);
            } else {
                $('#IsAdmin').prop('checked', false);
            }
            $("#CreateDate").val(Createdate);
            $("#btnAddRole").html('ویرایش نقش');
            $("#btnAddRole").removeClass('btn-primary');
            $("#btnAddRole").addClass('btn-warning');
        }
    </script>
    <!--Edit Part-->
    <script type="text/javascript">
        var CurrentDeleteNid = '';
        var CurrentDeleteTypo = '';

        function DeleteModal(typo, Nid) {
            CurrentDeleteNid = Nid;
            CurrentDeleteTypo = typo;
            $("#DeleteItemModal").modal('show');
        }
        $("#btnDeleteModalSubmit").click(function(e) {
            e.preventDefault();
            $("#waitText").removeAttr('hidden');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/submitdeleterole/' + CurrentDeleteNid,
                type: 'post',
                datatype: 'json',
                success: function(result) {
                    $("#waitText").attr('hidden', 'hidden');
                    if (result.HasValue) {
                        $("#RoleTableWrapper").html(result.Html);
                        $("#RoleSuccessMessage").text(result.Message);
                        $("#RoleSuccessAlert").removeAttr('hidden');
                        window.setTimeout(function() {
                            $("#RoleSuccessAlert").attr('hidden', 'hidden');
                        }, 3000);
                    } else {
                        $("#RoleErrorMessage").text(result.Message);
                        $("#RoleErrorAlert").removeAttr('hidden');
                        window.setTimeout(function() {
                            $("#RoleErrorAlert").attr('hidden', 'hidden');
                        }, 3000);
                    }
                },
                error: function() {
                    $("#waitText").attr('hidden', 'hidden');
                    $("#RoleErrorMessage").text('خطا در سرور.لطفا مجددا امتحان کنید');
                    $("#RoleErrorAlert").removeAttr('hidden');
                    window.setTimeout(function() {
                        $("#RoleErrorAlert").attr('hidden', 'hidden');
                    }, 3000);
                }
            });
            $("#DeleteItemModal").modal('hide');
        });
    </script>
    <!--Delete Part-->
@endsection
@endsection
