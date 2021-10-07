{{-- @model List<DataAccessLibrary.Models.Alarm> --}}
    <h6 class="dropdown-header" style="text-align:center;">
        اعلان ها
    </h6>
    @foreach ($alarms as $alm)
        @switch ($alm->AlarmSubject)
            @case ('PreImployment')
                <a class="dropdown-item d-flex align-items-center" href="{{ link_to_route('alarm.Alarms','',$type = 1) }}">
                    <div class="mr-3">
                        <div class="icon-circle bg-warning">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">تاریخ روگرفت</div>
                        <span class="font-weight-bold">{{ sprintf("%d پروژه نامه روگرفتشان دریافت نشده است",$alm->Description) }}</span>
                    </div>
                </a>
                @break
            @case ('SecurityLetter')
                <a class="dropdown-item d-flex align-items-center" href="{{ link_to_route('alarm.Alarms','',$type = 2) }}">
                    <div class="mr-3">
                        <div class="icon-circle bg-gradient-warning">
                            <i class="fas fa-file-signature text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">نامه حفاظت</div>
                        <span class="font-weight-bold">{{ sprintf("%d پروژه نامه حفاظت شان دریافت نشده است",$alm->Description) }}</span>
                    </div>
                </a>
                @break
            @case ('ThirtyLetter')
                <a class="dropdown-item d-flex align-items-center" href="{{ link_to_route('alarm.Alarms','',$type = 3) }}">
                    <div class="mr-3">
                        <div class="icon-circle bg-gradient-warning">
                            <i class="fas fa-file-signature text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">فرم 30 درصد</div>
                        <span class="font-weight-bold">{{ sprintf("%d پروژه فرم 30 درصدشان دریافت نشده است",$alm->Description) }}</span>
                    </div>
                </a>
                @break
            @case ('SixtyLetter')
                <a class="dropdown-item d-flex align-items-center" href="{{ link_to_route('alarm.Alarms','',$type = 4) }}">
                    <div class="mr-3">
                        <div class="icon-circle bg-gradient-warning">
                            <i class="fas fa-file-signature text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">فرم 60 درصد</div>
                        <span class="font-weight-bold">{{ sprintf("%d پروژه فرم 60 درصدشان دریافت نشده است",$alm->Description) }}</span>
                    </div>
                </a>
                @break
            @case ('ThesisLetter')
                <a class="dropdown-item d-flex align-items-center" href="{{ link_to_route('alarm.Alarms','',$type = 5) }}">
                    <div class="mr-3">
                        <div class="icon-circle bg-gradient-warning">
                            <i class="fas fa-file-signature text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">دفاعیه</div>
                        <span class="font-weight-bold">{{ sprintf("%d پروژه دفاعیه شان برگزار نشده است",$alm->Description) }}</span>
                    </div>
                </a>
                @break
            @case ('RefInfo')
                <a class="dropdown-item d-flex align-items-center" href="{{ link_to_route('alarm.Alarms','',$type = 6) }}">
                    <div class="mr-3">
                        <div class="icon-circle bg-gradient-warning">
                            <i class="fas fa-file-signature text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">داور 1 و 2</div>
                        <span class="font-weight-bold">{{ sprintf("%d پروژه داور 1 و 2 شان مشخص نشده است",$alm->Description) }}</span>
                    </div>
                </a>
                @break
            @case ('EditorInfo')
                <a class="dropdown-item d-flex align-items-center" href="{{ link_to_route('alarm.Alarms','',$type = 7) }}">
                    <div class="mr-3">
                        <div class="icon-circle bg-gradient-warning">
                            <i class="fas fa-file-signature text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">ویراستار</div>
                        <span class="font-weight-bold">{{ sprintf("%d پروژه ویراستارشان مشخص نشده است",$alm->Description) }}</span>
                    </div>
                </a>
                @break
            @case ('AdvSupInfo')
                <a class="dropdown-item d-flex align-items-center" href="{{ link_to_route('alarm.Alarms','',$type = 8) }}">
                    <div class="mr-3">
                        <div class="icon-circle bg-gradient-warning">
                            <i class="fas fa-file-signature text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">استاد راهنما و مشاور</div>
                        <span class="font-weight-bold">{{ sprintf("%d پروژه استاد راهنما و مشاورشان مشخص نشده است",$alm->Description) }}</span>
                    </div>
                </a>
                @break
        @endswitch
    @endforeach
    <a class="dropdown-item text-center small text-gray-500" href="{{ route('alarm.Alarms') }}">نمایش تمامی اعلان ها</a>
