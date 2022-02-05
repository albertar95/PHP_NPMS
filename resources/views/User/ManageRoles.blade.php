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
                        <div class="alert alert-success alert-dismissible" role="alert" id="RoleSuccessAlert"
                        hidden>
                        <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <p style="text-align:right;" id="RoleSuccessMessage"></p>
                    </div>
                    <div class="alert alert-warning alert-dismissible" role="alert" id="RoleWarningAlert"
                        hidden>
                        <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <p style="text-align:right;" id="RoleWarningMessage"></p>
                    </div>
                    <div class="alert alert-danger alert-dismissible" role="alert" id="RoleErrorAlert" hidden>
                        <button type="button" class="close" data-dismiss="alert"
                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <p style="text-align:right;" id="RoleErrorMessage"></p>
                    </div>
                    <form class="user" id="RolesForm" enctype="multipart/form-data">
                        <div class="form-group row">
                            <div class="col-sm-2 mb-3 mb-sm-0">
                                <input type="text" value="" id="NidRole" name="NidRole" hidden />
                                <input type="datetime" value="" id="CreateDate" name="CreateDate" hidden />
                                <input type="text" class="form-control form-control-user" id="Title"
                                    name="Title" placeholder="عنوان نقش">
                            </div>
                            <div class="col-sm-2" style="display: flex;">
                                <input type="checkbox" style="width:1rem;margin:unset !important;" id="IsAdmin" name="IsAdmin" class="form-control" alt="" onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                <label for="IsAdmin" style="margin:.45rem .45rem 0 0">نقش مدیر باشد؟</label>
                            </div>
                            <div class="col-sm-2">
                                <button class="btn btn-primary btn-user btn-block" type="submit"
                                    id="btnAddRole">
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
                                @foreach ($Roles as $key => $role)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $role->Title }}</td>
                                        @if($role->IsAdmin)
                                        <td>نقش مدیر</td>
                                        @else
                                        <td>نقش عادی</td>
                                        @endforelse
                                        <td>
                                            <button class="btn btn-danger"
                                                onclick="DeleteModal(1,'{{ $role->NidRole }}')">حذف</button>
                                            <button class="btn btn-warning"
                                                onclick="EditThis('{{ $role->NidRole }}','{{ $role->Title }}','{{ $role->CreateDate }}','{{ $role->IsAdmin }}')">ویرایش</button>
                                            <a href="/managerolepermissions/{{ $role->NidRole }}" class="btn btn-info">اعمال دسترسی</a>
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
    <div class="modal" id="DeleteItemModal" tabindex="-1" role="dialog" aria-labelledby="DeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DeleteModalLabel">حذف</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">آیا برای حذف اطمینان دارید ؟</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">خیر</button>
                    <a class="btn btn-primary" id="btnDeleteModalSubmit" href="#">بله</a>
                    <input type="text" id="CurrentDeleteNid" value="" hidden />
                    <input type="text" id="CurrentDeleteTypo" value="" hidden />
                </div>
            </div>
        </div>
    </div>
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
        function EditThis(Nid, Title,Createdate,IsAdmin) {
            $("#NidRole").val(Nid);
            $("#Title").val(Title);
            $("#IsAdmin").val(IsAdmin);
            if(IsAdmin == 1)
            {
                $('#IsAdmin').prop('checked', true);
            }
            else
            {
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
