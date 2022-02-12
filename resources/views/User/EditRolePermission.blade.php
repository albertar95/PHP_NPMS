@extends('Layouts.app')

@section('Content')

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">دسترسی نقش</h1>
                        </div>
                        @if (in_array('0', $sharedData['UserAccessedEntities']))
                            <form class="user" id="EditRolePermissionForm"
                                action="{{ route('user.SubmitEditRolePermission') }}" method="POST">
                                @csrf
                                <input type="text" id="NidPermission" name="NidPermission"
                                    value="{{ $Role->NidPermission }}" hidden>
                                <input type="text" id="CreateVal" name="CreateVal" value="{{ $Role->Create }}" hidden>
                                <input type="text" id="EditVal" name="EditVal" value="{{ $Role->Edit }}" hidden>
                                <input type="text" id="DeleteVal" name="DeleteVal" value="{{ $Role->Delete }}" hidden>
                                <input type="text" id="DetailVal" name="DetailVal" value="{{ $Role->Detail }}" hidden>
                                <input type="text" id="ConfidentVal" name="ConfidentVal" value="{{ $Role->Confident }}"
                                    hidden>
                                <input type="text" id="ListVal" name="ListVal" value="{{ $Role->List }}" hidden>
                                <input type="text" id="PrintVal" name="PrintVal" value="{{ $Role->Print }}" hidden>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0" style="display: flex;">
                                        <label>نقش</label>
                                        <select class="form-control allWidth" data-ng-style="btn-primary" id="RoleId"
                                            name="RoleId" style="padding:0 .75rem;">
                                            <option value="0" disabled>نقش</option>
                                            <option value="{{ $Roles->NidRole }}" selected>{{ $Roles->Title }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6" style="display: flex;">
                                        <label>موجودیت</label>
                                        <select class="form-control allWidth" data-ng-style="btn-primary" id="EntityId"
                                            name="EntityId" style="padding:0 .75rem;">
                                            <option value="0" disabled selected>موجودیت</option>
                                            @foreach ($Entities as $ent)
                                                @if ($ent['EntityId'] == $Role->EntityId)
                                                    <option value="{{ $ent['EntityId'] }}" selected>
                                                        {{ $ent['Title'] }}</option>
                                                @else
                                                    <option value="{{ $ent['EntityId'] }}">{{ $ent['Title'] }}
                                                    </option>
                                                @endforelse
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row" style="margin-top: 3rem;">
                                    <div class="col-sm-2" style="display: flex;">
                                        <label>دسترسی ها : </label>
                                    </div>
                                    <div class="col-sm-1" style="display: flex;">
                                        @if ($Role->Create)
                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="Create"
                                                name="Create" class="form-control" value="false" alt=""
                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" checked />
                                        @else
                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="Create"
                                                name="Create" class="form-control" value="false" alt=""
                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                        @endforelse
                                        <label for="Create" style="margin:.45rem .45rem 0 0">ایجاد</label>
                                    </div>
                                    <div class="col-sm-1" style="display: flex;">
                                        @if ($Role->Edit)
                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="Edit"
                                                name="Edit" class="form-control" value="false" alt=""
                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" checked />
                                        @else
                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="Edit"
                                                name="Edit" class="form-control" value="false" alt=""
                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                        @endforelse
                                        <label for="Edit" style="margin:.45rem .45rem 0 0">ویرایش</label>
                                    </div>
                                    <div class="col-sm-1" style="display: flex;">
                                        @if ($Role->Delete)
                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="Delete"
                                                name="Delete" class="form-control" value="false" alt=""
                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" checked />
                                        @else
                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="Delete"
                                                name="Delete" class="form-control" value="false" alt=""
                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                        @endforelse
                                        <label for="Delete" style="margin:.45rem .45rem 0 0">حذف</label>
                                    </div>
                                    <div class="col-sm-1" style="display: flex;">
                                        @if ($Role->Detail)
                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="Detail"
                                                name="Detail" class="form-control" value="false" alt=""
                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" checked />
                                        @else
                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="Detail"
                                                name="Detail" class="form-control" value="false" alt=""
                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                        @endforelse
                                        <label for="Detail" style="margin:.45rem .45rem 0 0">جزییات</label>
                                    </div>
                                    <div class="col-sm-1" style="display: flex;">
                                        @if ($Role->Confident)
                                            <input type="checkbox" style="width:1rem;margin:unset !important;"
                                                id="Confident" name="Confident" class="form-control" value="false" alt=""
                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" checked />
                                        @else
                                            <input type="checkbox" style="width:1rem;margin:unset !important;"
                                                id="Confident" name="Confident" class="form-control" value="false" alt=""
                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                        @endforelse
                                        <label for="Confident" style="margin:.45rem .45rem 0 0">محرمانه</label>
                                    </div>
                                    <div class="col-sm-1" style="display: flex;">
                                        @if ($Role->List)
                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="List"
                                                name="List" class="form-control" value="false" alt=""
                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" checked />
                                        @else
                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="List"
                                                name="List" class="form-control" value="false" alt=""
                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                        @endforelse
                                        <label for="List" style="margin:.45rem .45rem 0 0">لیست</label>
                                    </div>
                                    <div class="col-sm-1" style="display: flex;">
                                        @if ($Role->Print)
                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="Print"
                                                name="Print" class="form-control" value="false" alt=""
                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" checked />
                                        @else
                                            <input type="checkbox" style="width:1rem;margin:unset !important;" id="Print"
                                                name="Print" class="form-control" value="false" alt=""
                                                onclick="$(this).attr('value', this.checked ? 'true' : 'false')" />
                                        @endforelse
                                        <label for="Print" style="margin:.45rem .45rem 0 0">چاپ</label>
                                    </div>
                                </div>
                                <button type="submit" id="btnSubmit" class="btn btn-warning btn-user btn-block"
                                    style="width:25%;margin:auto;margin-top: 3rem;">
                                    ویرایش اطلاعات
                                </button>
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
            $("#Delete").change(function() {
                if ($(this).is(':checked')) {
                    $("#DeleteVal").val(1);
                } else {
                    $("#DeleteVal").val(0);
                }
            });
            $("#Detail").change(function() {
                if ($(this).is(':checked')) {
                    $("#DetailVal").val(1);
                } else {
                    $("#DetailVal").val(0);
                }
            });
            $("#Confident").change(function() {
                if ($(this).is(':checked')) {
                    $("#ConfidentVal").val(1);
                } else {
                    $("#ConfidentVal").val(0);
                }
            });
            $("#List").change(function() {
                if ($(this).is(':checked')) {
                    $("#ListVal").val(1);
                } else {
                    $("#ListVal").val(0);
                }
            });
            $("#Print").change(function() {
                if ($(this).is(':checked')) {
                    $("#PrintVal").val(1);
                } else {
                    $("#PrintVal").val(0);
                }
            });
        });
    </script>
@endsection
@endsection
