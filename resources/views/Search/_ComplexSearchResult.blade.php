@model DataAccessLibrary.Repositories.SearchRepository


@if (!is_null($Projects))
@foreach ($Projects as $prj)
    <div class="SearchWrap1">
        <div class="col-lg-2">
            <p class="SearchContent1">طرح</p>
        </div>
        <div class="col-lg-10">
            <a href="{{ link_to_route('project.ProjectDetail','',$NidProject = $prj->NidProject) }}">{{ $prj->Subject }}</a>
        </div>
    </div>
@endforeach
@endif
@if (!is_null($Scholars))
@foreach ($Scholars as $sch)
    <div class="SearchWrap1">
        <div class="col-lg-2">
            <p class="SearchContent1">محقق</p>
        </div>
        <div class="col-lg-10">
            <a href="#" onclick="ShowDetailModal(1,'{{ $sch->NidScholar }}')">{{ $sch->FirstName&nbsp;$sch->LastName }}</a>
        </div>
    </div>
@endforeach
@endif
@if (!is_null($Users))
@foreach ($Users as $usr)
    <div class="SearchWrap1">
        <div class="col-lg-2">
            <p class="SearchContent1">کاربر</p>
        </div>
        <div class="col-lg-10">
            <a href="#" onclick="ShowDetailModal(2,'{{ $usr->NidUser }}')">{{ $usr->FirstName&nbsp;$usr->LastName }}</a>
        </div>
    </div>
@endforeach
@endif
