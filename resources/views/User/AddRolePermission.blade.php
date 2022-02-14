@extends('Layouts.app')

@section('Content')

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row" style="margin:1rem;">
                @if (in_array('0', $sharedData['UserAccessedEntities']))
                <div class="col-sm-3">
                </div>
                <div class="col-sm-6"></div>
                <div class="col-sm-3">
                    <a id="btnReturn" class="btn btn-outline-info btn-block" style="direction: ltr;"
                        href="/managerolepermissions/{{ $Roles->NidRole }}">&larr; بازگشت</a>
                </div>
                @endif
            </div>
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">دسترسی نقش</h1>
                        </div>
                        @if (in_array('0', $sharedData['UserAccessedEntities']))
                            <form class="user" id="AddRolePermissionForm"
                                action="{{ route('user.SubmitAddRolePermission') }}" method="POST">
                                @csrf
                                <input type="text" id="NidPermission" name="NidPermission" hidden>
                                <input type="text" id="CreateVal" value="0" name="CreateVal" hidden>
                                <input type="text" id="EditVal" value="0" name="EditVal" hidden>
                                <input type="text" id="DeleteVal" value="0" name="DeleteVal" hidden>
                                <input type="text" id="DetailVal" value="0" name="DetailVal" hidden>
                                <input type="text" id="ListVal" value="0" name="ListVal" hidden>
                                <input type="text" id="ConfidentVal" value="0" name="ConfidentVal" hidden>
                                <input type="text" id="PrintVal" value="0" name="PrintVal" hidden>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <select class="form-control allWidth" data-ng-style="btn-primary" id="RoleId"
                                            name="RoleId" style="padding:0 .75rem;">
                                            <option value="0" disabled>نقش</option>
                                            <option value="{{ $Roles->NidRole }}" selected>{{ $Roles->Title }}</option>
                                            {{-- @foreach ($Roles as $rls)
                                        @endforeach --}}
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <select class="form-control allWidth" data-ng-style="btn-primary" id="EntityId"
                                            name="EntityId" style="padding:0 .75rem;">
                                            <option value="0" disabled selected>موجودیت</option>
                                            @foreach ($Entities as $ent)
                                                <option value="{{ $ent['EntityId'] }}">{{ $ent['Title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2" style="display: flex;">
                                        <label>دسترسی ها : </label>
                                    </div>
                                    <div class="col-sm-1" style="display: flex;">
                                        <input type="checkbox" style="width:1rem;margin:unset !important;" id="Create"
                                            name="Create" class="form-control" value="false" alt=""
                                            onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                        <label for="Create" style="margin:.45rem .45rem 0 0">ایجاد</label>
                                    </div>
                                    <div class="col-sm-1" style="display: flex;">
                                        <input type="checkbox" style="width:1rem;margin:unset !important;" id="Edit"
                                            name="Edit" class="form-control" value="false" alt=""
                                            onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                        <label for="Edit" style="margin:.45rem .45rem 0 0">ویرایش</label>
                                    </div>
                                    <div class="col-sm-1" style="display: flex;">
                                        <input type="checkbox" style="width:1rem;margin:unset !important;" id="Delete"
                                            name="Delete" class="form-control" value="false" alt=""
                                            onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                        <label for="Delete" style="margin:.45rem .45rem 0 0">حذف</label>
                                    </div>
                                    <div class="col-sm-1" style="display: flex;">
                                        <input type="checkbox" style="width:1rem;margin:unset !important;" id="Detail"
                                            name="Detail" class="form-control" value="false" alt=""
                                            onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                        <label for="Detail" style="margin:.45rem .45rem 0 0">جزییات</label>
                                    </div>
                                    <div class="col-sm-1" style="display: flex;">
                                        <input type="checkbox" style="width:1rem;margin:unset !important;" id="Confident"
                                            name="Confident" class="form-control" value="false" alt=""
                                            onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                        <label for="Confident" style="margin:.45rem .45rem 0 0">محرمانه</label>
                                    </div>
                                    <div class="col-sm-1" style="display: flex;">
                                        <input type="checkbox" style="width:1rem;margin:unset !important;" id="List"
                                            name="List" class="form-control" value="false" alt=""
                                            onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                        <label for="List" style="margin:.45rem .45rem 0 0">لیست</label>
                                    </div>
                                    <div class="col-sm-1" style="display: flex;">
                                        <input type="checkbox" style="width:1rem;margin:unset !important;" id="Print"
                                            name="Print" class="form-control" value="false" alt=""
                                            onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                        <label for="Print" style="margin:.45rem .45rem 0 0">چاپ</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                    <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                        <button type="submit" id="btnSubmit" class="btn btn-primary btn-user btn-block">
                                            ذخیره اطلاعات
                                        </button>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                                </div>
                                <hr />
                            </form>
                        @endif
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('styles')
<title>سامانه مدیریت تحقیقات - ایجاد دسترسی نقش</title>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(function() {
            $("#Create").change(function() {
                if ($(this).is(':checked')) {
                    $("#CreateVal").val(1);
                } else {
                    $("#CreateVal").val(0);
                }
            });
            $("#Edit").change(function() {
                if ($(this).is(':checked')) {
                    $("#EditVal").val(1);
                } else {
                    $("#EditVal").val(0);
                }
            });
            $("#Detail").change(function() {
                if ($(this).is(':checked')) {
                    $("#DetailVal").val(1);
                } else {
                    $("#DetailVal").val(0);
                }
            });
            $("#Delete").change(function() {
                if ($(this).is(':checked')) {
                    $("#DeleteVal").val(1);
                } else {
                    $("#DeleteVal").val(0);
                }
            });
            $("#List").change(function() {
                if ($(this).is(':checked')) {
                    $("#ListVal").val(1);
                } else {
                    $("#ListVal").val(0);
                }
            });
            $("#Confident").change(function() {
                if ($(this).is(':checked')) {
                    $("#ConfidentVal").val(1);
                } else {
                    $("#ConfidentVal").val(0);
                }
            });
            $("#Print").change(function() {
                if ($(this).is(':checked')) {
                    $("#PrintVal").val(1);
                } else {
                    $("#PrintVal").val(0);
                }
            });
            // $.ajaxSetup({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // });
            // $("#btnSubmit").click(function(e) {
            //     e.preventDefault();
            //     $.ajax({
            //         url: '/submitaddrolepermission',
            //         type: 'post',
            //         datatype: 'json',
            //         data: serialized,
            //         success: function(result) {
            //             if (result.HasValue) {
            //                 $("#SuccessMessage").text('دسترسی با موفقیت ایجاد گردید');
            //                 $("#successAlert").removeAttr('hidden');
            //                 $('#AddUserForm').each(function() {
            //                     this.reset();
            //                 });
            //                 window.setTimeout(function() {
            //                     $("#successAlert").attr('hidden', 'hidden');
            //                 }, 5000);
            //             } else {
            //                 $("#ErrorMessage").text(
            //                     'خطا در انجام عملیات.لطفا مجددا امتحان کنید')
            //                 $("#errorAlert").removeAttr('hidden')
            //                 window.setTimeout(function() {
            //                     $("#errorAlert").attr('hidden', 'hidden');
            //                 }, 5000);
            //             }
            //         },
            //         error: function() {
            //             $("#ErrorMessage").text('خطا در انجام عملیات.لطفا مجددا امتحان کنید')
            //             $("#errorAlert").removeAttr('hidden')
            //             window.setTimeout(function() {
            //                 $("#errorAlert").attr('hidden', 'hidden');
            //             }, 5000);
            //         }
            //     });
            // });
        });
    </script>
@endsection
@endsection
