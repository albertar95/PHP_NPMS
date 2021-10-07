@extends('Layouts.app')

@section('Content')

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">اعلان ها</h1>
                    </div>
                    {{ $tmpCounter = 1; }}
                    @switch ($Typo)
                    {
                        @case (0)
                            <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                <!-- Card Header - Accordion -->
                                <a href="#collapsePreImploymentItems" class="d-block card-header py-3" data-toggle="collapse"
                                   role="button" aria-expanded="true" aria-controls="collapsePreImploymentItems">
                                    <h6 class="m-0 font-weight-bold text-primary">تاریخ روگرفت</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapsePreImploymentItems" style="padding:.75rem;">
                                    <div class="table-responsive" dir="ltr" id="PreImploymentTableWrapper">
                                        <table class="table table-bordered" id="PreImploymentdataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($Alarms->where('AlarmSubject','=','PreImployment') as $prm)
                                                    <tr>
                                                        <td>{{ $tmpCounter }}</td>
                                                        <td>{{ $prm->Description }}</td>
                                                        <td>
                                                            <a href="{{ link_to_route('project.ProjectDetail','',$NidProject = $prm->NidMaster) }}" class="btn btn-secondary">جزییات پروژه</a>
                                                        </td>
                                                    </tr>
                                                    {{ $tmpCounter++; }}
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{ $tmpCounter = 1; }}
                            <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseSecurityItems" class="d-block card-header py-3" data-toggle="collapse"
                                   role="button" aria-expanded="true" aria-controls="collapseSecurityItems">
                                    <h6 class="m-0 font-weight-bold text-primary">نامه حفاظت</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseSecurityItems" style="padding:.75rem;">
                                    <div class="table-responsive" dir="ltr" id="SecurityTableWrapper">
                                        <table class="table table-bordered" id="SecuritydataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                            @foreach ($Alarms->where('AlarmSubject','=','SecurityLetter') as $prm)
                                                <tr>
                                                    <td>{{ $tmpCounter }}</td>
                                                    <td>{{ $prm->Description }}</td>
                                                    <td>
                                                        <a href="{{ link_to_route('project.ProjectDetail','',$NidProject = $prm->NidMaster) }}" class="btn btn-secondary">جزییات پروژه</a>
                                                    </td>
                                                </tr>
                                                {{ $tmpCounter++; }}
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{ $tmpCounter = 1; }}
                            <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseThirtyItems" class="d-block card-header py-3" data-toggle="collapse"
                                   role="button" aria-expanded="true" aria-controls="collapseThirtyItems">
                                    <h6 class="m-0 font-weight-bold text-primary">تحویل فرم 30 درصد</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseThirtyItems" style="padding:.75rem;">
                                    <div class="table-responsive" dir="ltr" id="ThirtyTableWrapper">
                                        <table class="table table-bordered" id="ThirtydataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                            @foreach ($Alarms->where('AlarmSubject','=','ThirtyLetter') as $prm)
                                                <tr>
                                                    <td>{{ $tmpCounter }}</td>
                                                    <td>{{ $prm->Description }}</td>
                                                    <td>
                                                        <a href="{{ link_to_route('project.ProjectDetail','',$NidProject = $prm->NidMaster) }}" class="btn btn-secondary">جزییات پروژه</a>
                                                    </td>
                                                </tr>
                                                {{ $tmpCounter++; }}
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{ $tmpCounter = 1; }}
                            <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseSixtyItems" class="d-block card-header py-3" data-toggle="collapse"
                                   role="button" aria-expanded="true" aria-controls="collapseSixtyItems">
                                    <h6 class="m-0 font-weight-bold text-primary">تحویل فرم 60 درصد</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseSixtyItems" style="padding:.75rem;">
                                    <div class="table-responsive" dir="ltr" id="SixtyTableWrapper">
                                        <table class="table table-bordered" id="SixtydataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($Alarms->where('AlarmSubject','=','SixtyLetter') as $prm)
                                                <tr>
                                                    <td>{{ $tmpCounter }}</td>
                                                    <td>{{ $prm->Description }}</td>
                                                    <td>
                                                        <a href="{{ link_to_route('project.ProjectDetail','',$NidProject = $prm->NidMaster) }}" class="btn btn-secondary">جزییات پروژه</a>
                                                    </td>
                                                </tr>
                                                {{ $tmpCounter++; }}
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{ $tmpCounter = 1; }}
                            <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseThesisItems" class="d-block card-header py-3" data-toggle="collapse"
                                   role="button" aria-expanded="true" aria-controls="collapseThesisItems">
                                    <h6 class="m-0 font-weight-bold text-primary">دفاعیه</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseThesisItems" style="padding:.75rem;">
                                    <div class="table-responsive" dir="ltr" id="ThesisTableWrapper">
                                        <table class="table table-bordered" id="ThesisdataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                            @foreach ($Alarms->where('AlarmSubject','=','ThesisLetter') as $prm)
                                                <tr>
                                                    <td>{{ $tmpCounter }}</td>
                                                    <td>{{ $prm->Description }}</td>
                                                    <td>
                                                        <a href="{{ link_to_route('project.ProjectDetail','',$NidProject = $prm->NidMaster) }}" class="btn btn-secondary">جزییات پروژه</a>
                                                    </td>
                                                </tr>
                                                {{ $tmpCounter++; }}
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{ $tmpCounter = 1; }}
                            <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseRefItems" class="d-block card-header py-3" data-toggle="collapse"
                                   role="button" aria-expanded="true" aria-controls="collapseRefItems">
                                    <h6 class="m-0 font-weight-bold text-primary">تعیین داور 1 و 2</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseRefItems" style="padding:.75rem;">
                                    <div class="table-responsive" dir="ltr" id="RefTableWrapper">
                                        <table class="table table-bordered" id="RefdataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($Alarms->where('AlarmSubject','=','RefInfo') as $prm)
                                                <tr>
                                                    <td>{{ $tmpCounter }}</td>
                                                    <td>{{ $prm->Description }}</td>
                                                    <td>
                                                        <a href="{{ link_to_route('project.ProjectDetail','',$NidProject = $prm->NidMaster) }}" class="btn btn-secondary">جزییات پروژه</a>
                                                    </td>
                                                </tr>
                                                {{ $tmpCounter++; }}
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{ $tmpCounter = 1; }}
                            <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseEditorItems" class="d-block card-header py-3" data-toggle="collapse"
                                   role="button" aria-expanded="true" aria-controls="collapseEditorItems">
                                    <h6 class="m-0 font-weight-bold text-primary">تعیین ویراستار</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseEditorItems" style="padding:.75rem;">
                                    <div class="table-responsive" dir="ltr" id="EditorTableWrapper">
                                        <table class="table table-bordered" id="EditordataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($Alarms->where('AlarmSubject','=','EditorInfo') as $prm)
                                                <tr>
                                                    <td>{{ $tmpCounter }}</td>
                                                    <td>{{ $prm->Description }}</td>
                                                    <td>
                                                        <a href="{{ link_to_route('project.ProjectDetail','',$NidProject = $prm->NidMaster) }}" class="btn btn-secondary">جزییات پروژه</a>
                                                    </td>
                                                </tr>
                                                {{ $tmpCounter++; }}
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            {{ $tmpCounter = 1; }}
                            <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseAdvSupItems" class="d-block card-header py-3" data-toggle="collapse"
                                   role="button" aria-expanded="true" aria-controls="collapseAdvSupItems">
                                    <h6 class="m-0 font-weight-bold text-primary">تعیین استاد راهنما و مشاور</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseAdvSupItems" style="padding:.75rem;">
                                    <div class="table-responsive" dir="ltr" id="AdvSupTableWrapper">
                                        <table class="table table-bordered" id="AdvSupdataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($Alarms->where('AlarmSubject','=','AdvSupInfo') as $prm)
                                                <tr>
                                                    <td>{{ $tmpCounter }}</td>
                                                    <td>{{ $prm->Description }}</td>
                                                    <td>
                                                        <a href="{{ link_to_route('project.ProjectDetail','',$NidProject = $prm->NidMaster) }}" class="btn btn-secondary">جزییات پروژه</a>
                                                    </td>
                                                </tr>
                                                {{ $tmpCounter++; }}
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @break
                        @case (1)
                        {{ $tmpCounter = 1; }}
                            <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                <!-- Card Header - Accordion -->
                                <a href="#collapsePreImploymentItems" class="d-block card-header py-3" data-toggle="collapse"
                                   role="button" aria-expanded="true" aria-controls="collapsePreImploymentItems">
                                    <h6 class="m-0 font-weight-bold text-primary">تاریخ روگرفت</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapsePreImploymentItems" style="padding:.75rem;">
                                    <div class="table-responsive" dir="ltr" id="PreImploymentTableWrapper">
                                        <table class="table table-bordered" id="PreImploymentdataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($Alarms->where('AlarmSubject','=','PreImployment') as $prm)
                                                <tr>
                                                    <td>{{ $tmpCounter }}</td>
                                                    <td>{{ $prm->Description }}</td>
                                                    <td>
                                                        <a href="{{ link_to_route('project.ProjectDetail','',$NidProject = $prm->NidMaster) }}" class="btn btn-secondary">جزییات پروژه</a>
                                                    </td>
                                                </tr>
                                                {{ $tmpCounter++; }}
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @break
                        @case (2)
                        {{ $tmpCounter = 1; }}
                            <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseSecurityItems" class="d-block card-header py-3" data-toggle="collapse"
                                   role="button" aria-expanded="true" aria-controls="collapseSecurityItems">
                                    <h6 class="m-0 font-weight-bold text-primary">نامه حفاظت</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseSecurityItems" style="padding:.75rem;">
                                    <div class="table-responsive" dir="ltr" id="SecurityTableWrapper">
                                        <table class="table table-bordered" id="SecuritydataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($Alarms->where('AlarmSubject','=','SecurityLetter') as $prm)
                                                <tr>
                                                    <td>{{ $tmpCounter }}</td>
                                                    <td>{{ $prm->Description }}</td>
                                                    <td>
                                                        <a href="{{ link_to_route('project.ProjectDetail','',$NidProject = $prm->NidMaster) }}" class="btn btn-secondary">جزییات پروژه</a>
                                                    </td>
                                                </tr>
                                                {{ $tmpCounter++; }}
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @break
                        @case (3)
                        {{ $tmpCounter = 1; }}
                            <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseThirtyItems" class="d-block card-header py-3" data-toggle="collapse"
                                   role="button" aria-expanded="true" aria-controls="collapseThirtyItems">
                                    <h6 class="m-0 font-weight-bold text-primary">تحویل فرم 30 درصد</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseThirtyItems" style="padding:.75rem;">
                                    <div class="table-responsive" dir="ltr" id="ThirtyTableWrapper">
                                        <table class="table table-bordered" id="ThirtydataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($Alarms->where('AlarmSubject','=','ThirtyLetter') as $prm)
                                                <tr>
                                                    <td>{{ $tmpCounter }}</td>
                                                    <td>{{ $prm->Description }}</td>
                                                    <td>
                                                        <a href="{{ link_to_route('project.ProjectDetail','',$NidProject = $prm->NidMaster) }}" class="btn btn-secondary">جزییات پروژه</a>
                                                    </td>
                                                </tr>
                                                {{ $tmpCounter++; }}
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @break
                        @case (4)
                        {{ $tmpCounter = 1; }}
                            <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseSixtyItems" class="d-block card-header py-3" data-toggle="collapse"
                                   role="button" aria-expanded="true" aria-controls="collapseSixtyItems">
                                    <h6 class="m-0 font-weight-bold text-primary">تحویل فرم 60 درصد</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseSixtyItems" style="padding:.75rem;">
                                    <div class="table-responsive" dir="ltr" id="SixtyTableWrapper">
                                        <table class="table table-bordered" id="SixtydataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($Alarms->where('AlarmSubject','=','SixtyLetter') as $prm)
                                                <tr>
                                                    <td>{{ $tmpCounter }}</td>
                                                    <td>{{ $prm->Description }}</td>
                                                    <td>
                                                        <a href="{{ link_to_route('project.ProjectDetail','',$NidProject = $prm->NidMaster) }}" class="btn btn-secondary">جزییات پروژه</a>
                                                    </td>
                                                </tr>
                                                {{ $tmpCounter++; }}
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @break
                        @case (5)
                        {{ $tmpCounter = 1; }}
                            <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseThesisItems" class="d-block card-header py-3" data-toggle="collapse"
                                   role="button" aria-expanded="true" aria-controls="collapseThesisItems">
                                    <h6 class="m-0 font-weight-bold text-primary">دفاعیه</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseThesisItems" style="padding:.75rem;">
                                    <div class="table-responsive" dir="ltr" id="ThesisTableWrapper">
                                        <table class="table table-bordered" id="ThesisdataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($Alarms->where('AlarmSubject','=','ThesisLetter') as $prm)
                                                <tr>
                                                    <td>{{ $tmpCounter }}</td>
                                                    <td>{{ $prm->Description }}</td>
                                                    <td>
                                                        <a href="{{ link_to_route('project.ProjectDetail','',$NidProject = $prm->NidMaster) }}" class="btn btn-secondary">جزییات پروژه</a>
                                                    </td>
                                                </tr>
                                                {{ $tmpCounter++; }}
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @break
                        @case (6)
                        {{ $tmpCounter = 1; }}
                            <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseRefItems" class="d-block card-header py-3" data-toggle="collapse"
                                   role="button" aria-expanded="true" aria-controls="collapseRefItems">
                                    <h6 class="m-0 font-weight-bold text-primary">تعیین داور 1 و 2</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseRefItems" style="padding:.75rem;">
                                    <div class="table-responsive" dir="ltr" id="RefTableWrapper">
                                        <table class="table table-bordered" id="RefdataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($Alarms->where('AlarmSubject','=','RefInfo') as $prm)
                                                <tr>
                                                    <td>{{ $tmpCounter }}</td>
                                                    <td>{{ $prm->Description }}</td>
                                                    <td>
                                                        <a href="{{ link_to_route('project.ProjectDetail','',$NidProject = $prm->NidMaster) }}" class="btn btn-secondary">جزییات پروژه</a>
                                                    </td>
                                                </tr>
                                                {{ $tmpCounter++; }}
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @break
                        @case (7)
                        {{ $tmpCounter = 1; }}
                            <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseEditorItems" class="d-block card-header py-3" data-toggle="collapse"
                                   role="button" aria-expanded="true" aria-controls="collapseEditorItems">
                                    <h6 class="m-0 font-weight-bold text-primary">تعیین ویراستار</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseEditorItems" style="padding:.75rem;">
                                    <div class="table-responsive" dir="ltr" id="EditorTableWrapper">
                                        <table class="table table-bordered" id="EditordataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($Alarms->where('AlarmSubject','=','EditorInfo') as $prm)
                                                <tr>
                                                    <td>{{ $tmpCounter }}</td>
                                                    <td>{{ $prm->Description }}</td>
                                                    <td>
                                                        <a href="{{ link_to_route('project.ProjectDetail','',$NidProject = $prm->NidMaster) }}" class="btn btn-secondary">جزییات پروژه</a>
                                                    </td>
                                                </tr>
                                                {{ $tmpCounter++; }}
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @break
                        @case (8)
                            {{ $tmpCounter = 1; }}
                            <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                                <!-- Card Header - Accordion -->
                                <a href="#collapseAdvSupItems" class="d-block card-header py-3" data-toggle="collapse"
                                   role="button" aria-expanded="true" aria-controls="collapseAdvSupItems">
                                    <h6 class="m-0 font-weight-bold text-primary">تعیین استاد راهنما و مشاور</h6>
                                </a>
                                <!-- Card Content - Collapse -->
                                <div class="collapse show" id="collapseAdvSupItems" style="padding:.75rem;">
                                    <div class="table-responsive" dir="ltr" id="AdvSupTableWrapper">
                                        <table class="table table-bordered" id="AdvSupdataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>شرح</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach ($Alarms->where('AlarmSubject','=','AdvSupInfo') as $prm)
                                                <tr>
                                                    <td>{{ $tmpCounter }}</td>
                                                    <td>{{ $prm->Description }}</td>
                                                    <td>
                                                        <a href="{{ link_to_route('project.ProjectDetail','',$NidProject = $prm->NidMaster) }}" class="btn btn-secondary">جزییات پروژه</a>
                                                    </td>
                                                </tr>
                                                {{ $tmpCounter++; }}
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @break
                    @endswitch
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
