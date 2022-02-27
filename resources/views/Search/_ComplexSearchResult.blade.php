@if (in_array('2', $sharedData['UserAccessedEntities']))
    @if (!is_null($Projects))
        @foreach ($Projects as $prj)
            <div class="SearchWrap1">
                <div class="col-lg-2">
                    <p class="SearchContent1">طرح</p>
                </div>
                <div class="col-lg-10">
                    <a href="{{ sprintf("%s/%s",URL::to('/projectdetail'),$prj->NidProject) }}">{{ $prj->Subject }}</a>
                </div>
            </div>
        @endforeach
    @endif
@endif
@if (in_array('1', $sharedData['UserAccessedEntities']))
    @if (!is_null($Scholars))
        @foreach ($Scholars as $sch)
            <div class="SearchWrap1">
                <div class="col-lg-2">
                    <p class="SearchContent1">محقق</p>
                </div>
                <div class="col-lg-10">
                    <a href="#" onclick="ShowDetailModal(1,'{{ $sch->NidScholar }}')">{{ $sch->FirstName }}
                        {{ $sch->LastName }}</a>
                </div>
            </div>
        @endforeach
    @endif
@endif
@if (in_array('3', $sharedData['UserAccessedEntities']))
    @if (!is_null($Users))
        @foreach ($Users as $usr)
            <div class="SearchWrap1">
                <div class="col-lg-2">
                    <p class="SearchContent1">کاربر</p>
                </div>
                <div class="col-lg-10">
                    <a href="#" onclick="ShowDetailModal(2,'{{ $usr->NidUser }}')">{{ $usr->FirstName }}
                        {{ $usr->LastName }}</a>
                </div>
            </div>
        @endforeach
    @endif
@endif
