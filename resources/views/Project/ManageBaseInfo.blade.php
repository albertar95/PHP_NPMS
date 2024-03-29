@extends('Layouts.app')

@section('Content')
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">مدیریت اطلاعات پایه</h1>
                        </div>
                        <div class="card shadow" style="margin-bottom:1rem;">
                            <!-- Card Header - Accordion -->
                            <a href="#collapseUnitItems" style="text-align:right;" class="d-block card-header py-3 collapsed"
                                data-toggle="collapse" role="button" aria-expanded="false"
                                aria-controls="collapseUnitItems">
                                <h6 class="m-0 font-weight-bold text-primary">یگان تخصصی</h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse" id="collapseUnitItems" style="padding:.75rem;">
                                <div class="alert alert-success alert-dismissible" role="alert" id="UnitSuccessAlert"
                                    hidden>
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <p style="text-align:right;" id="UnitSuccessMessage"></p>
                                </div>
                                <div class="alert alert-warning alert-dismissible" role="alert" id="UnitWarningAlert"
                                    hidden>
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <p style="text-align:right;" id="UnitWarningMessage"></p>
                                </div>
                                <div class="alert alert-danger alert-dismissible" role="alert" id="UnitErrorAlert" hidden>
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <p style="text-align:right;" id="UnitErrorMessage"></p>
                                </div>
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[0] == 1)
                                        <form class="user" id="UnitsForm"
                                            enctype="application/x-www-form-urlencoded">
                                            <div class="form-group row">
                                                <div class="col-sm-4 mb-3 mb-sm-0">
                                                    <input type="text" value="" id="NidUnit" name="NidUnit" hidden />
                                                    <input type="text" class="form-control form-control-user" id="UnitTitle"
                                                        name="Title" placeholder="عنوان یگان">
                                                </div>
                                                <div class="col-sm-4">
                                                    <button class="btn btn-primary btn-user btn-block" type="submit"
                                                        id="btnAddUnit">
                                                        ایجاد یگان
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                @endif
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    <div class="table-responsive" dir="ltr" id="UnitTableWrapper">
                                        <table class="table table-bordered" id="UnitdataTable"
                                            style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    {{-- <th>ردیف</th> --}}
                                                    <th>عنوان یگان</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    {{-- <th>ردیف</th> --}}
                                                    <th>عنوان یگان</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($Units as $key => $unit)
                                                    <tr>
                                                        {{-- <td>{{ $key + 1 }}</td> --}}
                                                        <td>{{ $unit->Title }}</td>
                                                        <td>
                                                            @if (in_array('6', $sharedData['UserAccessedEntities']))
                                                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[2] == 1)
                                                                    <button class="btn btn-danger"
                                                                        onclick="DeleteModal(1,'{{ $unit->NidUnit }}')">حذف</button>
                                                                @endif
                                                            @endif
                                                            @if (in_array('6', $sharedData['UserAccessedEntities']))
                                                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[1] == 1)
                                                                    <button class="btn btn-warning"
                                                                        onclick="EditThis(1,'{{ $unit->NidUnit }}','{{ $unit->Title }}','')">ویرایش</button>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card shadow" style="margin-bottom:1rem;">
                            <!-- Card Header - Accordion -->
                            <a href="#collapseUnitGroupsItems" style="text-align:right;"
                                class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="collapseUnitGroupsItems">
                                <h6 class="m-0 font-weight-bold text-primary">گروه تخصصی</h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse" style="padding:.75rem;" id="collapseUnitGroupsItems">
                                <div class="alert alert-success alert-dismissible" role="alert" id="UnitGroupSuccessAlert"
                                    hidden>
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <p style="text-align:right;" id="UnitGroupSuccessMessage"></p>
                                </div>
                                <div class="alert alert-warning alert-dismissible" role="alert" id="UnitGroupWarningAlert"
                                    hidden>
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <p style="text-align:right;" id="UnitGroupWarningMessage"></p>
                                </div>
                                <div class="alert alert-danger alert-dismissible" role="alert" id="UnitGroupErrorAlert"
                                    hidden>
                                    <button type="button" class="close" data-dismiss="alert"
                                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <p style="text-align:right;" id="UnitGroupErrorMessage"></p>
                                </div>
                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[0] == 1)
                                        <form class="user" id="UnitGroupsForm">
                                            <div class="form-group row">
                                                <div class="col-sm-4 mb-3 mb-sm-0">
                                                    <input type="text" value="" id="NidGroup" name="NidGroup" hidden />
                                                    <select class="form-control allWidth" data-ng-style="btn-primary"
                                                        id="UnitGroupsUnitId" name="UnitId" style="padding:0 .75rem;"
                                                        placeholder="انتخاب یگان">
                                                        <option value="0" disabled selected>انتخاب یگان</option>
                                                        @foreach ($Units->sortBy('Title') as $uni)
                                                            <option value="{{ $uni->NidUnit }}"
                                                                data-tokens="{{ $uni->Title }}">{{ $uni->Title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-4 mb-3 mb-sm-0">
                                                    <input type="text" class="form-control form-control-user"
                                                        id="GroupTitle" name="GroupTitle" placeholder="عنوان گروه">
                                                </div>
                                                <div class="col-sm-4">
                                                    <button class="btn btn-primary btn-user btn-block" type="submit"
                                                        id="btnAddGroup">
                                                        ایجاد گروه
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                @endif
                                <div class="table-responsive" dir="ltr" id="UnitGroupTableWrapper">
                                    @if (in_array('6', $sharedData['UserAccessedEntities']))
                                        <table class="table table-bordered" id="UnitGroupdataTable"
                                            style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    {{-- <th>ردیف</th> --}}
                                                    <th>یگان</th>
                                                    <th>عنوان گروه</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    {{-- <th>ردیف</th> --}}
                                                    <th>یگان</th>
                                                    <th>عنوان گروه</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($UnitGroups as $key => $unitgroup)
                                                    <tr>
                                                        {{-- <td>{{ $key + 1 }}</td> --}}
                                                        <td>{{ $Units->Where('NidUnit', '=', $unitgroup->UnitId)->firstOrFail()->Title }}
                                                        </td>
                                                        <td>{{ $unitgroup->Title }}</td>
                                                        <td>
                                                            @if (in_array('6', $sharedData['UserAccessedEntities']))
                                                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[2] == 1)
                                                                    <button class="btn btn-danger"
                                                                        onclick="DeleteModal(2,'{{ $unitgroup->NidGroup }}')">حذف</button>
                                                                @endif
                                                            @endif
                                                            @if (in_array('6', $sharedData['UserAccessedEntities']))
                                                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[1] == 1)
                                                                    <button class="btn btn-warning"
                                                                        onclick="EditThis(2,'{{ $unitgroup->NidGroup }}','{{ $unitgroup->Title }}','{{ $unitgroup->UnitId }}')">ویرایش</button>
                                                                @endif
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card shadow" style="margin-bottom:1rem;">
                            <!-- Card Header - Accordion -->
                            <a href="#collapseGradesItems" style="text-align:right;"
                                class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="collapseGradesItems">
                                <h6 class="m-0 font-weight-bold text-primary">مقطع تحصیلی</h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse" style="padding:.75rem;" id="collapseGradesItems">
                                <div class="card-body">
                                    <div class="alert alert-success alert-dismissible" role="alert" id="GradeSuccessAlert"
                                        hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="GradeSuccessMessage"></p>
                                    </div>
                                    <div class="alert alert-warning alert-dismissible" role="alert" id="GradeWarningAlert"
                                        hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="GradeWarningMessage"></p>
                                    </div>
                                    <div class="alert alert-danger alert-dismissible" role="alert" id="GradeErrorAlert"
                                        hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="GradeErrorMessage"></p>
                                    </div>
                                    @if (in_array('6', $sharedData['UserAccessedEntities']))
                                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[0] == 1)
                                            <form class="user" id="GradesForm">
                                                <div class="form-group row">
                                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                                        <input type="text" value="" id="GradeNidSetting" name="NidSetting"
                                                            hidden />
                                                        <input type="text" value="" id="GradeSettingValue"
                                                            name="SettingValue" hidden />
                                                        <input type="text" value="GradeId" id="GradeSettingKey"
                                                            name="SettingKey" hidden />
                                                        <input type="checkbox" value="false" id="GradeIsDeleted"
                                                            name="IsDeleted" hidden />
                                                        <input type="text" class="form-control form-control-user"
                                                            id="GradeSettingTitle" name="SettingTitle"
                                                            placeholder="عنوان مقطع تحصیلی">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button class="btn btn-primary btn-user btn-block" type="submit"
                                                            id="btnAddGrade">
                                                            ایجاد مقطع تحصیلی
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    @endif
                                    <div class="table-responsive" dir="ltr" id="GradeTableWrapper">
                                        @if (in_array('6', $sharedData['UserAccessedEntities']))
                                            <table class="table table-bordered" id="GradedataTable"
                                                style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        {{-- <th>ردیف</th> --}}
                                                        <th>عنوان مقطع تحصیلی</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        {{-- <th>ردیف</th> --}}
                                                        <th>عنوان مقطع تحصیلی</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    @foreach ($Grades as $key => $grade)
                                                        <tr>
                                                            {{-- <td>{{ $key + 1 }}</td> --}}
                                                            <td>{{ $grade->SettingTitle }}</td>
                                                            <td>
                                                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[2] == 1)
                                                                        <button class="btn btn-danger"
                                                                            onclick="DeleteModal(3,'{{ $grade->NidSetting }}')">حذف</button>
                                                                    @endif
                                                                @endif
                                                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[1] == 1)
                                                                        <button class="btn btn-warning"
                                                                            onclick="EditThis(3,'{{ $grade->NidSetting }}','{{ $grade->SettingTitle }}','{{ $grade->SettingValue }}')">ویرایش</button>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow" style="margin-bottom:1rem;">
                            <!-- Card Header - Accordion -->
                            <a href="#collapseMajorsItems" style="text-align:right;"
                                class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="collapseMajorsItems">
                                <h6 class="m-0 font-weight-bold text-primary">رشته تحصیلی</h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse" style="padding:.75rem;" id="collapseMajorsItems">
                                <div class="card-body">
                                    <div class="alert alert-success alert-dismissible" role="alert" id="MajorSuccessAlert"
                                        hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="MajorSuccessMessage"></p>
                                    </div>
                                    <div class="alert alert-warning alert-dismissible" role="alert" id="MajorWarningAlert"
                                        hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="MajorWarningMessage"></p>
                                    </div>
                                    <div class="alert alert-danger alert-dismissible" role="alert" id="MajorErrorAlert"
                                        hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="MajorErrorMessage"></p>
                                    </div>
                                    @if (in_array('6', $sharedData['UserAccessedEntities']))
                                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[0] == 1)
                                            <form class="user" id="MajorsForm">
                                                <div class="form-group row">
                                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                                        <input type="text" value="" id="NidMajor" name="NidMajor" hidden />
                                                        <input type="text" class="form-control form-control-user"
                                                            id="MajorTitle" name="Title" placeholder="عنوان رشته تحصیلی">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button class="btn btn-primary btn-user btn-block" type="submit"
                                                            id="btnAddMajor">
                                                            ایجاد رشته تحصیلی
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    @endif
                                    <div class="table-responsive" dir="ltr" id="MajorTableWrapper">
                                        @if (in_array('6', $sharedData['UserAccessedEntities']))
                                            <table class="table table-bordered" id="MajordataTable"
                                                style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        {{-- <th>ردیف</th> --}}
                                                        <th>عنوان رشته تحصیلی</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        {{-- <th>ردیف</th> --}}
                                                        <th>عنوان رشته تحصیلی</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    @foreach ($Majors as $key => $major)
                                                        <tr>
                                                            {{-- <td>{{ $key + 1 }}</td> --}}
                                                            <td>{{ $major->Title }}</td>
                                                            <td>
                                                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[2] == 1)
                                                                        <button class="btn btn-danger"
                                                                            onclick="DeleteModal(4,'{{ $major->NidMajor }}')">حذف</button>
                                                                    @endif
                                                                @endif
                                                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[1] == 1)
                                                                        <button class="btn btn-warning"
                                                                            onclick="EditThis(4,'{{ $major->NidMajor }}','{{ $major->Title }}','')">ویرایش</button>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow" style="margin-bottom:1rem;">
                            <!-- Card Header - Accordion -->
                            <a href="#collapseOreintationsItems" style="text-align:right;"
                                class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="collapseOreintationsItems">
                                <h6 class="m-0 font-weight-bold text-primary">گرایش</h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse" style="padding:.75rem;" id="collapseOreintationsItems">
                                <div class="card-body">
                                    <div class="alert alert-success alert-dismissible" role="alert"
                                        id="OreintationSuccessAlert" hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="OreintationSuccessMessage"></p>
                                    </div>
                                    <div class="alert alert-warning alert-dismissible" role="alert"
                                        id="OreintationWarningAlert" hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="OreintationWarningMessage"></p>
                                    </div>
                                    <div class="alert alert-danger alert-dismissible" role="alert"
                                        id="OreintationErrorAlert" hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="OreintationErrorMessage"></p>
                                    </div>
                                    @if (in_array('6', $sharedData['UserAccessedEntities']))
                                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[0] == 1)
                                            <form class="user" id="OreintationsForm">
                                                <div class="form-group row">
                                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                                        <input type="text" value="" id="NidOreintation"
                                                            name="NidOreintation" hidden />
                                                        <select class="form-control allWidth" data-ng-style="btn-primary"
                                                            name="MajorId" id="OreintationMajorId"
                                                            placeholder="انتخاب رشته تحصیلی" style="padding:0 .75rem;">
                                                            <option value="0" disabled selected>انتخاب رشته تحصیلی</option>
                                                            @foreach ($Majors as $ore)
                                                                <option value="{{ $ore->NidMajor }}"
                                                                    data-tokens="{{ $ore->Title }}">{{ $ore->Title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                                        <input type="text" class="form-control form-control-user"
                                                            id="OreintationTitle" name="Title" placeholder="عنوان گرایش">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button class="btn btn-primary btn-user btn-block" type="submit"
                                                            id="btnAddOreintation">
                                                            ایجاد گرایش
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    @endif
                                    <div class="table-responsive" dir="ltr" id="OreintationTableWrapper">
                                        @if (in_array('6', $sharedData['UserAccessedEntities']))
                                            <table class="table table-bordered" id="OreintationdataTable"
                                                style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        {{-- <th>ردیف</th> --}}
                                                        <th>رشته تحصیلی</th>
                                                        <th>عنوان گرایش</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        {{-- <th>ردیف</th> --}}
                                                        <th>رشته تحصیلی</th>
                                                        <th>عنوان گرایش</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    @foreach ($Oreintations as $key => $oreintation)
                                                        <tr>
                                                            <td>{{ $Majors->Where('NidMajor', '=', $oreintation->MajorId)->firstOrFail()->Title }}
                                                            </td>
                                                            <td>{{ $oreintation->Title }}</td>
                                                            <td>
                                                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[2] == 1)
                                                                        <button class="btn btn-danger"
                                                                            onclick="DeleteModal(5,'{{ $oreintation->NidOreintation }}')">حذف</button>
                                                                    @endif
                                                                @endif
                                                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[1] == 1)
                                                                        <button class="btn btn-warning"
                                                                            onclick="EditThis(5,'{{ $oreintation->NidOreintation }}','{{ $oreintation->Title }}','{{ $oreintation->MajorId }}')">ویرایش</button>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow" style="margin-bottom:1rem;">
                            <!-- Card Header - Accordion -->
                            <a href="#collapseCollegesItems" style="text-align:right;"
                                class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="collapseCollegesItems">
                                <h6 class="m-0 font-weight-bold text-primary">محل تحصیل</h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse" style="padding:.75rem;" id="collapseCollegesItems">
                                <div class="card-body">
                                    <div class="alert alert-success alert-dismissible" role="alert"
                                        id="CollegeSuccessAlert" hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="CollegeSuccessMessage"></p>
                                    </div>
                                    <div class="alert alert-warning alert-dismissible" role="alert"
                                        id="CollegeWarningAlert" hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="CollegeWarningMessage"></p>
                                    </div>
                                    <div class="alert alert-danger alert-dismissible" role="alert" id="CollegeErrorAlert"
                                        hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="CollegeErrorMessage"></p>
                                    </div>
                                    @if (in_array('6', $sharedData['UserAccessedEntities']))
                                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[0] == 1)
                                            <form class="user" id="CollegesForm">
                                                <div class="form-group row">
                                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                                        <input type="text" value="" id="CollegeNidSetting" name="NidSetting"
                                                            hidden />
                                                        <input type="text" value="" id="CollegeSettingValue"
                                                            name="SettingValue" hidden />
                                                        <input type="text" value="College" id="CollegeSettingKey"
                                                            name="SettingKey" hidden />
                                                        <input type="checkbox" value="false" id="CollegeIsDeleted"
                                                            name="IsDeleted" hidden />
                                                        <input type="text" class="form-control form-control-user"
                                                            id="CollegeSettingTitle" name="SettingTitle"
                                                            placeholder="عنوان دانشکده">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button class="btn btn-primary btn-user btn-block" type="submit"
                                                            id="btnAddCollege">
                                                            ایجاد دانشکده
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    @endif
                                    <div class="table-responsive" dir="ltr" id="CollegeTableWrapper">
                                        @if (in_array('6', $sharedData['UserAccessedEntities']))
                                            <table class="table table-bordered" id="CollegedataTable"
                                                style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        {{-- <th>ردیف</th> --}}
                                                        <th>عنوان دانشکده</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        {{-- <th>ردیف</th> --}}
                                                        <th>عنوان دانشکده</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    @foreach ($Colleges as $key => $college)
                                                        <tr>
                                                            {{-- <td>{{ $key + 1 }}</td> --}}
                                                            <td>{{ $college->SettingTitle }}</td>
                                                            <td>
                                                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[2] == 1)
                                                                        <button class="btn btn-danger"
                                                                            onclick="DeleteModal(6,'{{ $college->NidSetting }}')">حذف</button>
                                                                    @endif
                                                                @endif
                                                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[1] == 1)
                                                                        <button class="btn btn-warning"
                                                                            onclick="EditThis(6,'{{ $college->NidSetting }}','{{ $college->SettingTitle }}','{{ $college->SettingValue }}')">ویرایش</button>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow" style="margin-bottom:1rem;">
                            <!-- Card Header - Accordion -->
                            <a href="#collapseMillitaryStatusesItems" style="text-align:right;"
                                class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="collapseMillitaryStatusesItems">
                                <h6 class="m-0 font-weight-bold text-primary">وضعیت خدمتی</h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse" style="padding:.75rem;" id="collapseMillitaryStatusesItems">
                                <div class="card-body">
                                    <div class="alert alert-success alert-dismissible" role="alert" id="MillitSuccessAlert"
                                        hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="MillitSuccessMessage"></p>
                                    </div>
                                    <div class="alert alert-warning alert-dismissible" role="alert" id="MillitWarningAlert"
                                        hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="MillitWarningMessage"></p>
                                    </div>
                                    <div class="alert alert-danger alert-dismissible" role="alert" id="MillitErrorAlert"
                                        hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="MillitErrorMessage"></p>
                                    </div>
                                    @if (in_array('6', $sharedData['UserAccessedEntities']))
                                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[0] == 1)
                                            <form class="user" id="MillitsForm">
                                                <div class="form-group row">
                                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                                        <input type="text" value="" id="MillitNidSetting" name="NidSetting"
                                                            hidden />
                                                        <input type="text" value="" id="MillitSettingValue"
                                                            name="SettingValue" hidden />
                                                        <input type="text" value="MillitaryStatus" id="MillitSettingKey"
                                                            name="SettingKey" hidden />
                                                        <input type="checkbox" value="false" id="MillitIsDeleted"
                                                            name="IsDeleted" hidden />
                                                        <input type="text" class="form-control form-control-user"
                                                            id="MillitSettingTitle" name="SettingTitle"
                                                            placeholder="عنوان وضعیت خدمتی">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button class="btn btn-primary btn-user btn-block" type="submit"
                                                            id="btnAddMillit">
                                                            ایجاد وضعیت خدمتی
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    @endif
                                    <div class="table-responsive" dir="ltr" id="MillitTableWrapper">
                                        @if (in_array('6', $sharedData['UserAccessedEntities']))
                                            <table class="table table-bordered" id="MillitdataTable"
                                                style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        {{-- <th>ردیف</th> --}}
                                                        <th>عنوان وضعیت خدمتی</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        {{-- <th>ردیف</th> --}}
                                                        <th>عنوان وضعیت خدمتی</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    @foreach ($MillitaryStatuses as $key => $millit)
                                                        <tr>
                                                            {{-- <td>{{ $key + 1 }}</td> --}}
                                                            <td>{{ $millit->SettingTitle }}</td>
                                                            <td>
                                                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[2] == 1)
                                                                        <button class="btn btn-danger"
                                                                            onclick="DeleteModal(7,'{{ $millit->NidSetting }}')">حذف</button>
                                                                    @endif
                                                                @endif
                                                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[1] == 1)
                                                                        <button class="btn btn-warning"
                                                                            onclick="EditThis(7,'{{ $millit->NidSetting }}','{{ $millit->SettingTitle }}','{{ $millit->SettingValue }}')">ویرایش</button>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow" style="margin-bottom:1rem;">
                            <!-- Card Header - Accordion -->
                            <a href="#collapseCollaborationTypesItems" style="text-align:right;"
                                class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="collapseCollaborationTypesItems">
                                <h6 class="m-0 font-weight-bold text-primary">نوع همکاری</h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse" style="padding:.75rem;" id="collapseCollaborationTypesItems">
                                <div class="card-body">
                                    <div class="alert alert-success alert-dismissible" role="alert" id="CollabSuccessAlert"
                                        hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="CollabSuccessMessage"></p>
                                    </div>
                                    <div class="alert alert-warning alert-dismissible" role="alert" id="CollabWarningAlert"
                                        hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="CollabWarningMessage"></p>
                                    </div>
                                    <div class="alert alert-danger alert-dismissible" role="alert" id="CollabErrorAlert"
                                        hidden>
                                        <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <p style="text-align:right;" id="CollabErrorMessage"></p>
                                    </div>
                                    @if (in_array('6', $sharedData['UserAccessedEntities']))
                                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[0] == 1)
                                            <form class="user" id="CollabsForm">
                                                <div class="form-group row">
                                                    <div class="col-sm-4 mb-3 mb-sm-0">
                                                        <input type="text" value="" id="CollabNidSetting" name="NidSetting"
                                                            hidden />
                                                        <input type="text" value="" id="CollabSettingValue"
                                                            name="SettingValue" hidden />
                                                        <input type="text" value="CollaborationType" id="CollabSettingKey"
                                                            name="SettingKey" hidden />
                                                        <input type="checkbox" value="false" id="CollabIsDeleted"
                                                            name="IsDeleted" hidden />
                                                        <input type="text" class="form-control form-control-user"
                                                            id="CollabSettingTitle" name="SettingTitle"
                                                            placeholder="عنوان نوع همکاری">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <button class="btn btn-primary btn-user btn-block" type="submit"
                                                            id="btnAddCollab">
                                                            ایجاد نوع همکاری
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    @endif
                                    <div class="table-responsive" dir="ltr" id="CollabTableWrapper">
                                        @if (in_array('6', $sharedData['UserAccessedEntities']))
                                            <table class="table table-bordered" id="CollabdataTable"
                                                style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        {{-- <th>ردیف</th> --}}
                                                        <th>عنوان نوع همکاری</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        {{-- <th>ردیف</th> --}}
                                                        <th>عنوان نوع همکاری</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    @foreach ($CollaborationTypes as $key => $collab)
                                                        <tr>
                                                            {{-- <td>{{ $key + 1 }}</td> --}}
                                                            <td>{{ $collab->SettingTitle }}</td>
                                                            <td>
                                                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[2] == 1)
                                                                        <button class="btn btn-danger"
                                                                            onclick="DeleteModal(8,'{{ $collab->NidSetting }}')">حذف</button>
                                                                    @endif
                                                                @endif
                                                                @if (in_array('6', $sharedData['UserAccessedEntities']))
                                                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[1] == 1)
                                                                        <button class="btn btn-warning"
                                                                            onclick="EditThis(8,'{{ $collab->NidSetting }}','{{ $collab->SettingTitle }}','{{ $collab->SettingValue }}')">ویرایش</button>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
                            <div class="col-sm-6 col-md-6 col-lg-4 col-xl-4">
                                @if (in_array('2', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 2)->pluck('rowValue')[0])[4] == 1)
                                        <a class="btn btn-outline-secondary btn-user btn-block"
                                            href="{{ route('project.Projects') }}">لیست طرح
                                            ها</a>
                                    @endif
                                @endif
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-4 col-xl-4"></div>
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
                <div class="modal-body">
                    <p id="DeleteQuestion" style="margin:0 auto;font-size:xx-large;font-weight:bolder;text-align: right;">
                        آیا برای حذف اطمینان دارید ؟
                    </p>
                </div>
                <div class="modal-footer">
                    <div class="col-lg-12">
                        <button class="btn btn-success" type="button" style="margin:0 auto;width:15%;"
                            id="btnDeleteModalSubmit">بلی</button>
                        <button class="btn btn-danger" type="button" style="margin:0 0 0 35%;width:15%;"
                            data-dismiss="modal" id="btnCancel">خیر</button>
                    </div>
                    <input type="text" id="CurrentDeleteNid" value="" hidden />
                    <input type="text" id="CurrentDeleteTypo" value="" hidden />
                </div>
            </div>
        </div>
    </div>
@section('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <title>سامانه مدیریت تحقیقات - مدیریت اطلاعات پایه</title>
@endsection
@section('scripts')
    <script src="{{ URL('Content/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL('Content/js/demo/datatables-demo.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $("#UnitdataTable").dataTable();
            $("#UnitGroupdataTable").dataTable();
            $("#GradedataTable").dataTable();
            $("#MajordataTable").dataTable();
            $("#OreintationdataTable").dataTable();
            $("#CollegedataTable").dataTable();
            $("#MillitdataTable").dataTable();
            $("#CollabdataTable").dataTable();
            $('#UnitGroupsUnitId').selectize({
                sortField: 'value'
            });
            $('#OreintationMajorId').selectize({
                sortField: 'value'
            });
            $("#btnAddUnit").click(function(e) {
                e.preventDefault();
                var model = {
                    NidUnit: $("#NidUnit").val(),
                    Title: $("#UnitTitle").val()
                };
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ URL::to('/') }}' + '/submitunitform',
                    type: 'post',
                    datatype: 'json',
                    data: JSON.stringify(model),
                    contentType: "application/json",
                    success: function(result) {
                        if (result.HasValue) {
                            $("#UnitTableWrapper").html(result.Html);
                            $("#UnitdataTable").dataTable();
                            $("#UnitsForm").each(function() {
                                this.reset();
                            });
                            $("#UnitSuccessMessage").text(result.Message);
                            $("#UnitSuccessAlert").removeAttr('hidden');
                            $("#btnAddUnit").html('ایجاد یگان');
                            $("#btnAddUnit").removeClass('btn-warning');
                            $("#btnAddUnit").addClass('btn-primary');
                            window.setTimeout(function() {
                                $("#UnitSuccessAlert").attr('hidden', 'hidden');
                                location.reload();
                            }, 3000);
                            // $("#UnitGroupsUnitId option").each(function() {
                            //     if ($(this).val() == model.NidUnit) {
                            //         $(this).remove();
                            //     }
                            // });
                            // $("#UnitGroupsUnitId").append(new Option(model.Title, result
                            //     .AltProp));
                        } else {
                            $("#UnitErrorMessage").text(result.Message);
                            $("#UnitErrorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#UnitErrorAlert").attr('hidden', 'hidden');
                            }, 3000);
                        }
                    },
                    error: function() {
                        var message = "";
                        jQuery.each(response.responseJSON.errors, function(i, val) {
                            message += val;
                        });
                        $("#UnitErrorMessage").text(message)
                        // $("#UnitErrorMessage").text('خطا در سرور.لطفا مجددا امتحان کنید');
                        $("#UnitErrorAlert").removeAttr('hidden');
                        window.setTimeout(function() {
                            $("#UnitErrorAlert").attr('hidden', 'hidden');
                        }, 3000);
                    }
                });
            });
            $("#btnAddGroup").click(function(e) {
                e.preventDefault();
                var model = {
                    NidGroup: $("#NidGroup").val(),
                    Title: $("#GroupTitle").val(),
                    UnitId: $("#UnitGroupsUnitId").val()
                };
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ URL::to('/') }}' + '/submitunitgroupform',
                    type: 'post',
                    datatype: 'json',
                    data: JSON.stringify(model),
                    contentType: "application/json",
                    success: function(result) {
                        if (result.HasValue) {
                            $("#UnitGroupTableWrapper").html(result.Html);
                            $("#UnitGroupdataTable").dataTable();
                            $("#UnitGroupsForm").each(function() {
                                this.reset();
                            });
                            $("#UnitGroupSuccessMessage").text(result.Message);
                            $("#UnitGroupSuccessAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#UnitGroupSuccessAlert").attr('hidden', 'hidden');
                            }, 3000);
                            $("#btnAddGroup").html('ایجاد گروه');
                            $("#btnAddGroup").removeClass('btn-warning');
                            $("#btnAddGroup").addClass('btn-primary');
                        } else {
                            $("#UnitGroupErrorMessage").text(result.Message);
                            $("#UnitGroupErrorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#UnitGroupErrorAlert").attr('hidden', 'hidden');
                            }, 3000);
                        }
                    },
                    error: function() {
                        var message = "";
                        jQuery.each(response.responseJSON.errors, function(i, val) {
                            message += val;
                        });
                        $("#UnitGroupErrorMessage").text(message)
                        // $("#UnitGroupErrorMessage").text('خطا در سرور.لطفا مجددا امتحان کنید');
                        $("#UnitGroupErrorAlert").removeAttr('hidden');
                        window.setTimeout(function() {
                            $("#UnitGroupErrorAlert").attr('hidden', 'hidden');
                        }, 3000);
                    }
                });
            });
            $("#btnAddGrade").click(function(e) {
                e.preventDefault();
                var model = {
                    NidSetting: $("#GradeNidSetting").val(),
                    SettingValue: $("#GradeSettingValue").val(),
                    SettingKey: $("#GradeSettingKey").val(),
                    SettingTitle: $("#GradeSettingTitle").val(),
                    IsDeleted: $("#GradeIsDeleted").val()
                };
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ URL::to('/') }}' + '/submitgradeform',
                    type: 'post',
                    datatype: 'json',
                    data: JSON.stringify(model),
                    contentType: "application/json",
                    success: function(result) {
                        if (result.HasValue) {
                            $("#GradeTableWrapper").html(result.Html);
                            $("#GradedataTable").dataTable();
                            $("#GradesForm").each(function() {
                                this.reset();
                            });
                            $("#GradeSuccessMessage").text(result.Message);
                            $("#GradeSuccessAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#GradeSuccessAlert").attr('hidden', 'hidden');
                            }, 3000);
                            $("#btnAddGrade").html('ایجاد مقطع تحصیلی');
                            $("#btnAddGrade").removeClass('btn-warning');
                            $("#btnAddGrade").addClass('btn-primary');
                        } else {
                            $("#GradeErrorMessage").text(result.Message);
                            $("#GradeErrorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#GradeErrorAlert").attr('hidden', 'hidden');
                            }, 3000);
                        }
                    },
                    error: function() {
                        $("#GradeErrorMessage").text('خطا در سرور.لطفا مجددا امتحان کنید');
                        $("#GradeErrorAlert").removeAttr('hidden');
                        window.setTimeout(function() {
                            $("#GradeErrorAlert").attr('hidden', 'hidden');
                        }, 3000);
                    }
                });
            });
            $("#btnAddMajor").click(function(e) {
                e.preventDefault();
                var model = {
                    NidMajor: $("#NidMajor").val(),
                    Title: $("#MajorTitle").val()
                };
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ URL::to('/') }}' + '/submitmajorform',
                    type: 'post',
                    datatype: 'json',
                    data: JSON.stringify(model),
                    contentType: "application/json",
                    success: function(result) {
                        if (result.HasValue) {
                            $("#MajorTableWrapper").html(result.Html);
                            $("#MajordataTable").dataTable();
                            $("#MajorsForm").each(function() {
                                this.reset();
                            });
                            $("#MajorSuccessMessage").text(result.Message);
                            $("#MajorSuccessAlert").removeAttr('hidden');
                            $("#btnAddMajor").html('ایجاد رشته تحصیلی');
                            $("#btnAddMajor").removeClass('btn-warning');
                            $("#btnAddMajor").addClass('btn-primary');
                            window.setTimeout(function() {
                                $("#MajorSuccessAlert").attr('hidden', 'hidden');
                                location.reload();
                            }, 3000);
                            // $("#OreintationMajorId option").each(function() {
                            //     if ($(this).val() == model.NidMajor) {
                            //         $(this).remove();
                            //     }
                            // });
                            // $("#OreintationMajorId").append(new Option(model.Title, result
                            //     .AltProp));
                        } else {
                            $("#MajorErrorMessage").text(result.Message);
                            $("#MajorErrorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#MajorErrorAlert").attr('hidden', 'hidden');
                            }, 3000);
                        }
                    },
                    error: function() {
                        var message = "";
                        jQuery.each(response.responseJSON.errors, function(i, val) {
                            message += val;
                        });
                        $("#UnitErrorMessage").text(message)
                        // $("#UnitErrorMessage").text('خطا در سرور.لطفا مجددا امتحان کنید');
                        $("#UnitErrorAlert").removeAttr('hidden');
                        window.setTimeout(function() {
                            $("#UnitErrorAlert").attr('hidden', 'hidden');
                        }, 3000);
                    }
                });
            });
            $("#btnAddOreintation").click(function(e) {
                e.preventDefault();
                var model = {
                    NidOreintation: $("#NidOreintation").val(),
                    Title: $("#OreintationTitle").val(),
                    MajorId: $("#OreintationMajorId").val()
                };
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ URL::to('/') }}' + '/submitoreintationform',
                    type: 'post',
                    datatype: 'json',
                    data: JSON.stringify(model),
                    contentType: "application/json",
                    success: function(result) {
                        if (result.HasValue) {
                            $("#OreintationTableWrapper").html(result.Html);
                            $("#OreintationdataTable").dataTable();
                            $("#OreintationsForm").each(function() {
                                this.reset();
                            });
                            $("#OreintationSuccessMessage").text(result.Message);
                            $("#OreintationSuccessAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#OreintationSuccessAlert").attr('hidden', 'hidden');
                            }, 3000);
                            $("#btnAddOreintation").html('ایجاد گرایش');
                            $("#btnAddOreintation").removeClass('btn-warning');
                            $("#btnAddOreintation").addClass('btn-primary');
                        } else {
                            $("#OreintationErrorMessage").text(result.Message);
                            $("#OreintationErrorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#OreintationErrorAlert").attr('hidden', 'hidden');
                            }, 3000);
                        }
                    },
                    error: function() {
                        var message = "";
                        jQuery.each(response.responseJSON.errors, function(i, val) {
                            message += val;
                        });
                        $("#OreintationErrorMessage").text(message)
                        // $("#OreintationErrorMessage").text(
                        //     'خطا در سرور.لطفا مجددا امتحان کنید');
                        $("#OreintationErrorAlert").removeAttr('hidden');
                        window.setTimeout(function() {
                            $("#OreintationErrorAlert").attr('hidden', 'hidden');
                        }, 3000);
                    }
                });
            });
            $("#btnAddCollege").click(function(e) {
                e.preventDefault();
                var model = {
                    NidSetting: $("#CollegeNidSetting").val(),
                    SettingValue: $("#CollegeSettingValue").val(),
                    SettingKey: $("#CollegeSettingKey").val(),
                    SettingTitle: $("#CollegeSettingTitle").val(),
                    IsDeleted: $("#CollegeIsDeleted").val()
                };
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ URL::to('/') }}' + '/submitcollegeform',
                    type: 'post',
                    datatype: 'json',
                    data: JSON.stringify(model),
                    contentType: "application/json",
                    success: function(result) {
                        if (result.HasValue) {
                            $("#CollegeTableWrapper").html(result.Html);
                            $("#CollegedataTable").dataTable();
                            $("#CollegesForm").each(function() {
                                this.reset();
                            });
                            $("#CollegeSuccessMessage").text(result.Message);
                            $("#CollegeSuccessAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#CollegeSuccessAlert").attr('hidden', 'hidden');
                            }, 3000);
                            $("#btnAddCollege").html('ایجاد دانشکده');
                            $("#btnAddCollege").removeClass('btn-warning');
                            $("#btnAddCollege").addClass('btn-primary');
                        } else {
                            $("#CollegeErrorMessage").text(result.Message);
                            $("#CollegeErrorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#CollegeErrorAlert").attr('hidden', 'hidden');
                            }, 3000);
                        }
                    },
                    error: function() {
                        $("#CollegeErrorMessage").text('خطا در سرور.لطفا مجددا امتحان کنید');
                        $("#CollegeErrorAlert").removeAttr('hidden');
                        window.setTimeout(function() {
                            $("#CollegeErrorAlert").attr('hidden', 'hidden');
                        }, 3000);
                    }
                });
            });
            $("#btnAddMillit").click(function(e) {
                e.preventDefault();
                var model = {
                    NidSetting: $("#MillitNidSetting").val(),
                    SettingValue: $("#MillitSettingValue").val(),
                    SettingKey: $("#MillitSettingKey").val(),
                    SettingTitle: $("#MillitSettingTitle").val(),
                    IsDeleted: $("#MillitIsDeleted").val()
                };
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ URL::to('/') }}' + '/submitmillitform',
                    type: 'post',
                    datatype: 'json',
                    data: JSON.stringify(model),
                    contentType: "application/json",
                    success: function(result) {
                        if (result.HasValue) {
                            $("#MillitTableWrapper").html(result.Html);
                            $("#MillitdataTable").dataTable();
                            $("#MillitsForm").each(function() {
                                this.reset();
                            });
                            $("#MillitSuccessMessage").text(result.Message);
                            $("#MillitSuccessAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#MillitSuccessAlert").attr('hidden', 'hidden');
                            }, 3000);
                            $("#btnAddMillit").html('ایجاد وضعیت خدمت');
                            $("#btnAddMillit").removeClass('btn-warning');
                            $("#btnAddMillit").addClass('btn-primary');
                        } else {
                            $("#MillitErrorMessage").text(result.Message);
                            $("#MillitErrorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#MillitErrorAlert").attr('hidden', 'hidden');
                            }, 3000);
                        }
                    },
                    error: function() {
                        $("#MillitErrorMessage").text('خطا در سرور.لطفا مجددا امتحان کنید');
                        $("#MillitErrorAlert").removeAttr('hidden');
                        window.setTimeout(function() {
                            $("#MillitErrorAlert").attr('hidden', 'hidden');
                        }, 3000);
                    }
                });
            });
            $("#btnAddCollab").click(function(e) {
                e.preventDefault();
                var model = {
                    NidSetting: $("#CollabNidSetting").val(),
                    SettingValue: $("#CollabSettingValue").val(),
                    SettingKey: $("#CollabSettingKey").val(),
                    SettingTitle: $("#CollabSettingTitle").val(),
                    IsDeleted: $("#CollabIsDeleted").val()
                };
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ URL::to('/') }}' + '/submitcollabform',
                    type: 'post',
                    datatype: 'json',
                    data: JSON.stringify(model),
                    contentType: "application/json",
                    success: function(result) {
                        if (result.HasValue) {
                            $("#CollabTableWrapper").html(result.Html);
                            $("#CollabdataTable").dataTable();
                            $("#CollabsForm").each(function() {
                                this.reset();
                            });
                            $("#CollabSuccessMessage").text(result.Message);
                            $("#CollabSuccessAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#CollabSuccessAlert").attr('hidden', 'hidden');
                            }, 3000);
                            $("#btnAddCollab").html('ایجاد نوع همکاری');
                            $("#btnAddCollab").removeClass('btn-warning');
                            $("#btnAddCollab").addClass('btn-primary');
                        } else {
                            $("#CollabErrorMessage").text(result.Message);
                            $("#CollabErrorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#CollabErrorAlert").attr('hidden', 'hidden');
                            }, 3000);
                        }
                    },
                    error: function() {
                        $("#CollabErrorMessage").text('خطا در سرور.لطفا مجددا امتحان کنید');
                        $("#CollabErrorAlert").removeAttr('hidden');
                        window.setTimeout(function() {
                            $("#CollabErrorAlert").attr('hidden', 'hidden');
                        }, 3000);
                    }
                });
            });
        });
    </script>
    <!--Form Submit Part-->
    <script type="text/javascript">
        function EditThis(typo, Nid, Title, SecondaryNid, IsDeleted) {
            switch (typo) {
                case 1:
                    $("#NidUnit").val(Nid);
                    $("#UnitTitle").val(Title);
                    $("#btnAddUnit").html('ویرایش یگان');
                    $("#btnAddUnit").removeClass('btn-primary');
                    $("#btnAddUnit").addClass('btn-warning');
                    break;
                case 2:
                    $("#NidGroup").val(Nid);
                    $("#UnitGroupsUnitId").val([]);
                    $("#UnitGroupsUnitId").val(SecondaryNid);
                    $("#GroupTitle").val(Title);
                    $("#btnAddGroup").html('ویرایش گروه');
                    $("#btnAddGroup").removeClass('btn-primary');
                    $("#btnAddGroup").addClass('btn-warning');
                    break;
                case 3:
                    $("#GradeNidSetting").val(Nid);
                    $("#GradeSettingTitle").val(Title);
                    $("#GradeSettingValue").val(SecondaryNid);
                    $("#GradeIsDeleted").val('false');
                    $("#btnAddGrade").html('ویرایش مقطع تحصیلی');
                    $("#btnAddGrade").removeClass('btn-primary');
                    $("#btnAddGrade").addClass('btn-warning');
                    break;
                case 4:
                    $("#NidMajor").val(Nid);
                    $("#MajorTitle").val(Title);
                    $("#btnAddMajor").html('ویرایش رشته تحصیلی');
                    $("#btnAddMajor").removeClass('btn-primary');
                    $("#btnAddMajor").addClass('btn-warning');
                    break;
                case 5:
                    $("#NidOreintation").val(Nid);
                    $("#OreintationMajorId").val([]);
                    $("#OreintationMajorId").val(SecondaryNid);
                    $("#OreintationTitle").val(Title);
                    $("#btnAddOreintation").html('ویرایش گرایش');
                    $("#btnAddOreintation").removeClass('btn-primary');
                    $("#btnAddOreintation").addClass('btn-warning');
                    break;
                case 6:
                    $("#CollegeNidSetting").val(Nid);
                    $("#CollegeSettingTitle").val(Title);
                    $("#CollegeSettingValue").val(SecondaryNid);
                    $("#CollegeIsDeleted").val('false');
                    $("#btnAddCollege").html('ویرایش دانشکده');
                    $("#btnAddCollege").removeClass('btn-primary');
                    $("#btnAddCollege").addClass('btn-warning');
                    break;
                case 7:
                    $("#MillitNidSetting").val(Nid);
                    $("#MillitSettingTitle").val(Title);
                    $("#MillitSettingValue").val(SecondaryNid);
                    $("#MillitIsDeleted").val('false');
                    $("#btnAddMillit").html('ویرایش دانشکده');
                    $("#btnAddMillit").removeClass('btn-primary');
                    $("#btnAddMillit").addClass('btn-warning');
                    break;
                case 8:
                    $("#CollabNidSetting").val(Nid);
                    $("#CollabSettingTitle").val(Title);
                    $("#CollabSettingValue").val(SecondaryNid);
                    $("#CollabIsDeleted").val('false');
                    $("#btnAddCollab").html('ویرایش دانشکده');
                    $("#btnAddCollab").removeClass('btn-primary');
                    $("#btnAddCollab").addClass('btn-warning');
                    break;
                default:
                    break;

            }
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
            switch (CurrentDeleteTypo) {
                case 1:
                    $.ajax({
                        url: '{{ URL::to('/') }}' + '/submitdeleteunit/' + CurrentDeleteNid,
                        type: 'post',
                        datatype: 'json',
                        success: function(result) {
                            if (result.HasValue) {
                                $("#UnitTableWrapper").html(result.Html);
                                $("#UnitdataTable").dataTable();
                                $("#UnitSuccessMessage").text(result.Message);
                                $("#UnitSuccessAlert").removeAttr('hidden');
                                window.setTimeout(function() {
                                    $("#UnitSuccessAlert").attr('hidden', 'hidden');
                                }, 3000);
                                $("#UnitGroupsUnitId option").each(function() {
                                    if ($(this).val() == CurrentDeleteNid) {
                                        $(this).remove();
                                    }
                                });
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
                    break;
                case 2:
                    $.ajax({
                        url: '{{ URL::to('/') }}' + '/submitdeleteunitgroup/' + CurrentDeleteNid,
                        type: 'post',
                        datatype: 'json',
                        success: function(result) {
                            if (result.HasValue) {
                                $("#UnitGroupTableWrapper").html(result.Html);
                                $("#UnitGroupdataTable").dataTable();
                                $("#UnitGroupSuccessMessage").text(result.Message);
                                $("#UnitGroupSuccessAlert").removeAttr('hidden');
                                window.setTimeout(function() {
                                    $("#UnitGroupSuccessAlert").attr('hidden', 'hidden');
                                }, 3000);
                            } else {
                                $("#UnitGroupErrorMessage").text(result.Message);
                                $("#UnitGroupErrorAlert").removeAttr('hidden');
                                window.setTimeout(function() {
                                    $("#UnitGroupErrorAlert").attr('hidden', 'hidden');
                                }, 3000);
                            }
                        },
                        error: function() {
                            $("#UnitGroupErrorMessage").text('خطا در سرور.لطفا مجددا امتحان کنید');
                            $("#UnitGroupErrorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#UnitGroupErrorAlert").attr('hidden', 'hidden');
                            }, 3000);
                        }
                    });
                    break;
                case 3:
                    $.ajax({
                        url: '{{ URL::to('/') }}' + '/submitdeletegrade/' + CurrentDeleteNid,
                        type: 'post',
                        datatype: 'json',
                        success: function(result) {
                            if (result.HasValue) {
                                $("#GradeTableWrapper").html(result.Html);
                                $("#GradedataTable").dataTable();
                                $("#GradeSuccessMessage").text(result.Message);
                                $("#GradeSuccessAlert").removeAttr('hidden');
                                window.setTimeout(function() {
                                    $("#GradeSuccessAlert").attr('hidden', 'hidden');
                                }, 3000);
                            } else {
                                $("#GradeErrorMessage").text(result.Message);
                                $("#GradeErrorAlert").removeAttr('hidden');
                                window.setTimeout(function() {
                                    $("#GradeErrorAlert").attr('hidden', 'hidden');
                                }, 3000);
                            }
                        },
                        error: function() {
                            $("#GradeErrorMessage").text('خطا در سرور.لطفا مجددا امتحان کنید');
                            $("#GradeErrorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#GradeErrorAlert").attr('hidden', 'hidden');
                            }, 3000);
                        }
                    });
                    break;
                case 4:
                    $.ajax({
                        url: '{{ URL::to('/') }}' + '/submitdeletemajor/' + CurrentDeleteNid,
                        type: 'post',
                        datatype: 'json',
                        success: function(result) {
                            if (result.HasValue) {
                                $("#MajorTableWrapper").html(result.Html);
                                $("#MajordataTable").dataTable();
                                $("#MajorSuccessMessage").text(result.Message);
                                $("#MajorSuccessAlert").removeAttr('hidden');
                                window.setTimeout(function() {
                                    $("#MajorSuccessAlert").attr('hidden', 'hidden');
                                }, 3000);
                                $("#OreintationMajorId option").each(function() {
                                    if ($(this).val() == CurrentDeleteNid) {
                                        $(this).remove();
                                    }
                                });
                            } else {
                                $("#MajorErrorMessage").text(result.Message);
                                $("#MajorErrorAlert").removeAttr('hidden');
                                window.setTimeout(function() {
                                    $("#MajorErrorAlert").attr('hidden', 'hidden');
                                }, 3000);
                            }
                        },
                        error: function() {
                            $("#MajorErrorMessage").text('خطا در سرور.لطفا مجددا امتحان کنید');
                            $("#MajorErrorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#MajorErrorAlert").attr('hidden', 'hidden');
                            }, 3000);
                        }
                    });
                    break;
                case 5:
                    $.ajax({
                        url: '{{ URL::to('/') }}' + '/submitdeleteoreintation/' + CurrentDeleteNid,
                        type: 'post',
                        datatype: 'json',
                        success: function(result) {
                            if (result.HasValue) {
                                $("#OreintationTableWrapper").html(result.Html);
                                $("#OreintationdataTable").dataTable();
                                $("#OreintationSuccessMessage").text(result.Message);
                                $("#OreintationSuccessAlert").removeAttr('hidden');
                                window.setTimeout(function() {
                                    $("#OreintationSuccessAlert").attr('hidden', 'hidden');
                                }, 3000);
                            } else {
                                $("#OreintationErrorMessage").text(result.Message);
                                $("#OreintationErrorAlert").removeAttr('hidden');
                                window.setTimeout(function() {
                                    $("#OreintationErrorAlert").attr('hidden', 'hidden');
                                }, 3000);
                            }
                        },
                        error: function() {
                            $("#OreintationErrorMessage").text('خطا در سرور.لطفا مجددا امتحان کنید');
                            $("#OreintationErrorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#OreintationErrorAlert").attr('hidden', 'hidden');
                            }, 3000);
                        }
                    });
                    break;
                case 6:
                    $.ajax({
                        url: '{{ URL::to('/') }}' + '/submitdeletecollege/' + CurrentDeleteNid,
                        type: 'post',
                        datatype: 'json',
                        success: function(result) {
                            if (result.HasValue) {
                                $("#CollegeTableWrapper").html(result.Html);
                                $("#CollegedataTable").dataTable();
                                $("#CollegeSuccessMessage").text(result.Message);
                                $("#CollegeSuccessAlert").removeAttr('hidden');
                                window.setTimeout(function() {
                                    $("#CollegeSuccessAlert").attr('hidden', 'hidden');
                                }, 3000);
                            } else {
                                $("#CollegeErrorMessage").text(result.Message);
                                $("#CollegeErrorAlert").removeAttr('hidden');
                                window.setTimeout(function() {
                                    $("#CollegeErrorAlert").attr('hidden', 'hidden');
                                }, 3000);
                            }
                        },
                        error: function() {
                            $("#CollegeErrorMessage").text('خطا در سرور.لطفا مجددا امتحان کنید');
                            $("#CollegeErrorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#CollegeErrorAlert").attr('hidden', 'hidden');
                            }, 3000);
                        }
                    });
                    break;
                case 7:
                    $.ajax({
                        url: '{{ URL::to('/') }}' + '/submitdeletemillit/' + CurrentDeleteNid,
                        type: 'post',
                        datatype: 'json',
                        success: function(result) {
                            if (result.HasValue) {
                                $("#MillitTableWrapper").html(result.Html);
                                $("#MillitdataTable").dataTable();
                                $("#MillitSuccessMessage").text(result.Message);
                                $("#MillitSuccessAlert").removeAttr('hidden');
                                window.setTimeout(function() {
                                    $("#MillitSuccessAlert").attr('hidden', 'hidden');
                                }, 3000);
                            } else {
                                $("#MillitErrorMessage").text(result.Message);
                                $("#MillitErrorAlert").removeAttr('hidden');
                                window.setTimeout(function() {
                                    $("#MillitErrorAlert").attr('hidden', 'hidden');
                                }, 3000);
                            }
                        },
                        error: function() {
                            $("#MillitErrorMessage").text('خطا در سرور.لطفا مجددا امتحان کنید');
                            $("#MillitErrorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#MillitErrorAlert").attr('hidden', 'hidden');
                            }, 3000);
                        }
                    });
                    break;
                case 8:
                    $.ajax({
                        url: '{{ URL::to('/') }}' + '/submitdeletecollab/' + CurrentDeleteNid,
                        type: 'post',
                        datatype: 'json',
                        success: function(result) {
                            if (result.HasValue) {
                                $("#CollabTableWrapper").html(result.Html);
                                $("#CollabdataTable").dataTable();
                                $("#CollabSuccessMessage").text(result.Message);
                                $("#CollabSuccessAlert").removeAttr('hidden');
                                window.setTimeout(function() {
                                    $("#CollabSuccessAlert").attr('hidden', 'hidden');
                                }, 3000);
                            } else {
                                $("#CollabErrorMessage").text(result.Message);
                                $("#CollabErrorAlert").removeAttr('hidden');
                                window.setTimeout(function() {
                                    $("#CollabErrorAlert").attr('hidden', 'hidden');
                                }, 3000);
                            }
                        },
                        error: function() {
                            $("#CollabErrorMessage").text('خطا در سرور.لطفا مجددا امتحان کنید');
                            $("#CollabErrorAlert").removeAttr('hidden');
                            window.setTimeout(function() {
                                $("#CollabErrorAlert").attr('hidden', 'hidden');
                            }, 3000);
                        }
                    });
                    break;
            }
            $("#DeleteItemModal").modal('hide');
        });
    </script>
    <!--Delete Part-->
@endsection
@endsection
