<html lang="en">

<head>
    @include('Layouts.Header')
    @yield('styles')
</head>

<body id="page-top">
    <div id="wrapper" style="direction:rtl;">
        <div class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" style="height:10rem;"
                href="{{ route('index') }}">
                <div class="sidebar-brand-icon">
                    <img src="{{ URL('Content/img/Logo/logo192.png') }}" style="width:100%;height:10rem;" />
                </div>
            </a>
            <p style="text-align:center;color:whitesmoke;">سامانه مدیریت تحقیقات</p>
            <hr class="sidebar-divider my-0">
            <div class="nav-item">
                <a class="nav-link" href="{{ route('index2') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>میز کار</span>
                </a>
            </div>
            <hr class="sidebar-divider">
            @if (in_array('1', $sharedData['UserAccessedEntities']) || in_array('2', $sharedData['UserAccessedEntities']))
                <div class="sidebar-heading">
                    بخش تحقیقات
                </div>
            @endif
            <!-- Nav Item - Pages Collapse Menu -->
            @if (in_array('1', $sharedData['UserAccessedEntities']))
                <div class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#ScholarPart"
                        aria-expanded="true" aria-controls="ScholarPart">
                        <i class="fas fa-fw fa-graduation-cap"></i>
                        <span>محقق</span>
                    </a>
                    <div id="ScholarPart" class="collapse" aria-labelledby="ScholarHeading"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[0] == 1)
                                <a class="collapse-item" href="{{ route('scholar.AddScholar') }}"
                                    style="text-align:right;">محقق جدید</a>
                            @endif
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 1)->pluck('rowValue')[0])[4] == 1)
                                <a class="collapse-item" href="{{ route('scholar.Scholars') }}"
                                    style="text-align:right;">مدیریت محققان</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            @if (in_array('2', $sharedData['UserAccessedEntities']))
                <!-- Nav Item - Utilities Collapse Menu -->
                <div class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#ProjectPart"
                        aria-expanded="true" aria-controls="ProjectPart">
                        <i class="fas fa-fw fa-file"></i>
                        <span>طرح</span>
                    </a>
                    <div id="ProjectPart" class="collapse" aria-labelledby="ProjectHeading"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 2)->pluck('rowValue')[0])[0] == 1)
                                <a class="collapse-item" href="{{ route('project.AddProject') }}"
                                    style="text-align:right;">طرح جدید</a>
                            @endif
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 2)->pluck('rowValue')[0])[4] == 1)
                                <a class="collapse-item" href="{{ route('project.Projects') }}"
                                    style="text-align:right;">مدیریت طرح ها</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            @if (in_array('1', $sharedData['UserAccessedEntities']) || in_array('2', $sharedData['UserAccessedEntities']))
                <hr class="sidebar-divider">
            @endif
            @if (in_array('4', $sharedData['UserAccessedEntities']))
                <div class="sidebar-heading">
                    بخش گزارشات
                </div>
                <!-- Nav Item - Pages Collapse Menu -->
                <div class="nav-item collapsed">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#ReportPart"
                        aria-expanded="true" aria-controls="ReportPart">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>گزارشات</span>
                    </a>
                    <div id="ReportPart" class="collapse" aria-labelledby="ReportHeading"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 4)->pluck('rowValue')[0])[4] == 1)
                                <a class="collapse-item" href="{{ route('report.StatisticReports') }}"
                                    style="text-align:right;">گزارشات آماری</a>
                            @endif
                            @if (in_array('0', $sharedData['UserAccessedEntities']))
                                <a class="collapse-item" href="{{ route('report.UserLogReport') }}"
                                    style="text-align:right;">گزارشات عملکرد کاربران</a>
                            @endif
                            @if (in_array('4', $sharedData['UserAccessedEntities']))
                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 4)->pluck('rowValue')[0])[0] == 1)
                                    <a class="collapse-item" href="{{ route('report.CustomReports') }}"
                                        style="text-align:right;">ایجاد گزارش سفارشی</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            <div class="nav-item">
                <a class="nav-link" href="{{ route('search.AdvanceSearch') }}">
                    <i class="fas fa-fw fa-search"></i>
                    <span>جستجو پیشرفته</span>
                </a>
            </div>
            <hr class="sidebar-divider">
            @if (in_array('3', $sharedData['UserAccessedEntities']))
                <div class="sidebar-heading">
                    بخش کاربران
                </div>
                <div class="nav-item collapsed">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#UserPart"
                        aria-expanded="true" aria-controls="UserPart">
                        <i class="fas fa-fw fa-user-circle"></i>
                        <span>کاربر</span>
                    </a>
                    <div id="UserPart" class="collapse" aria-labelledby="UserHeading"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 3)->pluck('rowValue')[0])[0] == 1)
                                <a class="collapse-item" href="{{ route('user.AddUser') }}"
                                    style="text-align:right;">ایجاد کاربر</a>
                            @endif
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 3)->pluck('rowValue')[0])[4] == 1)
                                <a class="collapse-item" href="{{ route('user.Users') }}"
                                    style="text-align:right;">مدیریت کاربران</a>
                            @endif
                            {{-- @if (in_array('0', $sharedData['UserAccessedEntities']))
                                <a class="collapse-item" href="{{ route('user.UserPermissions') }}"
                                    style="text-align:right;">مدیریت دسترسی ها</a>
                            @endif --}}
                        </div>
                    </div>
                </div>
            @endif
            @if (in_array('5', $sharedData['UserAccessedEntities']))
                <div class="nav-item collapsed">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#MessagePart"
                        aria-expanded="true" aria-controls="MessagePart">
                        <i class="fas fa-fw fa-envelope"></i>
                        <span>پیام ها</span>
                    </a>
                    <div id="MessagePart" class="collapse" aria-labelledby="MessageHeading"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 5)->pluck('rowValue')[0])[0] == 1)
                                <a class="collapse-item" href="{{ URL::to('/sendmessage') }}"
                                    style="text-align:right;">ارسال پیام</a>
                            @endif
                            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 5)->pluck('rowValue')[0])[4] == 1)
                                <a class="collapse-item"
                                    href="{{ sprintf('%s/%s', URL::to('/messages'), auth()->user()->NidUser) }}"
                                    style="text-align:right;">صندوق پیام</a>
                            @endif
                        </div>
                    </div>
                </div>
                <hr class="sidebar-divider d-none d-md-block">
            @endif
            @if (in_array('0', $sharedData['UserAccessedEntities']))
                <div class="sidebar-heading">
                    بخش تنظیمات
                </div>
                <div class="nav-item collapsed">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#SettingPart"
                        aria-expanded="true" aria-controls="SettingPart">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>تنظیمات امنیتی</span>
                    </a>
                    <div id="SettingPart" class="collapse" aria-labelledby="SettingHeading"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="{{ route('user.PasswordPolicy') }}"
                                style="text-align:right;">خط مشی کلمه عبور</a>
                            <a class="collapse-item" href="{{ route('user.ManageRoles') }}"
                                style="text-align:right;">مدیریت نقش ها</a>
                            {{-- <a class="collapse-item" href="{{ route('user.ManageRolePermissions') }}"
                                style="text-align:right;">مدیریت دسترسی ها</a> --}}
                            <a class="collapse-item" href="{{ route('user.ManageSessions') }}"
                                style="text-align:right;">مدیریت نشست ها</a>
                            @if (in_array('6', $sharedData['UserAccessedEntities']))
                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[4] == 1)
                                    <a class="collapse-item" href="{{ route('project.ManageBaseInfo') }}"
                                        style="text-align:right;">مدیریت اطلاعات پایه</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <hr class="sidebar-divider d-none d-md-block">
            @else
                @if (in_array('6', $sharedData['UserAccessedEntities']))
                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 6)->pluck('rowValue')[0])[4] == 1)
                        <div class="sidebar-heading">
                            بخش تنظیمات
                        </div>
                        <div class="nav-item collapsed">
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#SettingPart"
                                aria-expanded="true" aria-controls="SettingPart">
                                <i class="fas fa-fw fa-cog"></i>
                                <span>تنظیمات امنیتی</span>
                            </a>
                            <div id="SettingPart" class="collapse" aria-labelledby="SettingHeading"
                                data-parent="#accordionSidebar">
                                <div class="bg-white py-2 collapse-inner rounded">
                                    <a class="collapse-item" href="{{ route('project.ManageBaseInfo') }}"
                                        style="text-align:right;">مدیریت اطلاعات پایه</a>
                                </div>
                            </div>
                        </div>
                        <hr class="sidebar-divider d-none d-md-block">
                    @endif
                @endif
            @endforelse
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </div>
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="جستجو ..."
                                id="txtSearch" oninput="SearchAll()" aria-label="Search"
                                aria-describedby="basic-addon2">
                            <button class="close" type="button" id="ClearSearch" style="padding-left:.5rem;"
                                onclick="ClearSearchTxt()" hidden>
                                <span>×</span>
                            </button>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                        <div class="SearchContainer1" id="SearchResult"></div>
                    </form>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-left p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" id="txtSearchSm"
                                            oninput="SearchAllSm()" placeholder="جستجو..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <button class="close" type="button" id="ClearSearchSm"
                                            style="padding-left:.5rem;" onclick="ClearSearchTxt()" hidden>
                                            <span>×</span>
                                        </button>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="SearchContainer2" id="SearchResultSm"></div>
                                </form>
                            </div>
                        </li>
                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter" id="alarmCount">0</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-left shadow animated--grow-in"
                                aria-labelledby="alertsDropdown" id="AlarmsDropDown">
                                <h6 class="dropdown-header" style="text-align:center;">
                                    اعلان ها
                                </h6>
                                <a class="dropdown-item text-center small text-gray-500"
                                    href="{{ URL::to('/alarms/0') }}">نمایش تمامی
                                    اعلان ها</a>
                            </div>
                        </li>
                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter" id="messageCount">0</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-left shadow animated--grow-in"
                                aria-labelledby="messagesDropdown" id="MessagesDrop">
                                <h6 class="dropdown-header" style="text-align:center;">
                                    پیام ها
                                </h6>
                                @if (in_array('5', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 5)->pluck('rowValue')[0])[4] == 1)
                                        <a class="dropdown-item text-center small text-gray-500"
                                            href="{{ sprintf('%s/%s', URL::to('/messages'), auth()->user()->NidUser) }}">نمایش
                                            تمامی پیام ها</a>
                                    @endif
                                @endif
                            </div>
                        </li>
                        <li class="topbar-divider d-none d-sm-block"></li>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @auth
                                    <span
                                        class="ml-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->FirstName }}
                                        {{ auth()->user()->LastName }}</span>
                                    <span id="txtUserId" hidden>{{ auth()->user()->NidUser }}</span>
                                    @if (!empty(auth()->user()->ProfilePicture))
                                        <img src="{{ sprintf('/storage/images/%s', auth()->user()->ProfilePicture) }}"
                                            class="img-profile rounded-circle" />
                                    @else
                                        <img class="img-profile rounded-circle"
                                            src="{{ URL('Content/img/User/user3.png') }}">
                                    @endforelse
                                @endauth
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-left shadow animated--grow-in"
                                aria-labelledby="userDropdown" style="max-width:10.375rem !important;">
                                <a class="dropdown-item" href="{{ route('user.Profile') }}"
                                    style="text-align:right;">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    پروفایل
                                </a>
                                {{-- <a class="dropdown-item" href="#" style="text-align:right;">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    تنظیمات
                                </a> --}}
                                <a class="dropdown-item"
                                    href="{{ sprintf('%s/%s', URL::to('/profileuseractivityreport'), auth()->user()->NidUser) }}"
                                    style="text-align:right;">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    گزارش کاربری
                                </a>
                                <a class="dropdown-item"
                                href="{{ URL::to('/usermanual') }}"
                                style="text-align:right;">
                                <i class="fas fa-question-circle fa-sm fa-fw mr-2 text-gray-400"></i>
                                راهنما
                            </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"
                                    style="text-align:right;">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    خروج
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    @yield('Content')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <div class="modal" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="text-align:right;">
                <div class="modal-header" style="direction:rtl;">
                    <h5 class="modal-title" id="exampleModalLabel">خروج</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('user.Logout') }}" method="POST">
                    @csrf
                    <div class="modal-body">آیا برای خروج اطمینان دارید ؟</div>
                    <div class="modal-footer" style="margin:0 auto;">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">خیر</button>
                        <button class="btn btn-primary" type="submit">بله</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="EnteranceModal" tabindex="-1" role="dialog" aria-labelledby="EnteranceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EnteranceModalLabel">اخطار</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="uploadModalHeader" style="text-align:right;">کاربر گرامی شما به سامانه مدیریت تحقیقات نظری
                        نپاجا وارد شده اید.به اطلاع می رساند تمامی فعالیت های کاربران قابل ردیابی و بازبینی می باشدو
                        مسئولیت اطلاعات حساس سامانه بر عهده کاربر می باشد</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" style="margin: 0 auto;" type="button"
                        data-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="UploadModal" tabindex="-1" role="dialog" aria-labelledby="UploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="UploadModalLabel">بارگذاری</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h2 id="uploadModalHeader" style="text-align:right;">فایل در حال بارگذاری می باشد.لطفا منتظر بمانید
                    </h2>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" id="UploadProgress"
                            role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"
                            style="width: 100%"></div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="DetailModal" tabindex="-1" role="dialog" aria-labelledby="DetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DetailModalLabel"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" id="DetailModalBody">
                </div>
                <p id="DeleteQuestion" style="margin:0 auto;font-size:xx-large;font-weight:bolder;" hidden>آیا برای حذف
                    این محقق اطمینان دارید؟</p>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" id="btnClose" data-dismiss="modal"
                        style="margin:0 auto;width:10%;" hidden>بستن</button>
                    <div class="col-lg-12">
                        <button class="btn btn-success" type="button" style="margin:0 auto;width:15%;" id="btnOk"
                            hidden>بلی</button>
                        <button class="btn btn-danger" type="button" style="margin:0 0 0 35%;width:15%;"
                            data-dismiss="modal" id="btnCancel" hidden>خیر</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('Layouts.Footer')
    @yield('scripts')
    <script type="text/javascript">
        $(function() {
            GetUsersAlarms();
            GetUsersMessages();
            setInterval(function() {
                $.ajax({
                    url: '{{ URL::to('/') }}' + '/getrecievemessageneeded/' + $("#txtUserId")
                        .text(),
                    type: 'get',
                    datatype: 'json',
                    success: function(result) {
                        if (result.HasValue)
                            GetUsersMessages();
                    },
                    error: function() {}
                });
            }, 300 * 1000);
        });

        function AdvanceInProgressBar(newValue) {
            $("#UploadProgress").css('width', newValue + '%');
        }

        function UploadFile(typo) {
            AdvanceInProgressBar(0);
            $("#UploadMessage").attr('hidden', 'hidden');
            $("#UploadModal").modal('show');
            AdvanceInProgressBar(10);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            switch (typo) {
                case 1:
                    var sfilename = document.getElementById("ProfilePictureUpload").files[0].name;
                    var _validFileExtensions = [".jpg", ".jpeg", ".bmp", ".gif", ".png"];
                    var isValid = false;
                    for (var j = 0; j < _validFileExtensions.length; j++) {
                        var sCurExtension = _validFileExtensions[j];
                        if (sfilename.substr(sfilename.length - sCurExtension.length, sCurExtension.length).toLowerCase() ==
                            sCurExtension.toLowerCase()) {
                            isValid = true
                        }
                    }
                    if (isValid) {
                        var formData = new FormData();
                        formData.append('profile', document.getElementById("ProfilePictureUpload").files[0]);
                        formData.append('fileName', document.getElementById("ProfilePictureUpload").files[0].name);
                        formData.append('fileType', typo);
                        $.ajax({
                            url: '{{ URL::to('/') }}' + '/uploadthisfile',
                            type: 'post',
                            datatype: 'json',
                            data: formData,
                            contentType: false,
                            processData: false,
                            success: function(result) {
                                if (result.HasValue) {
                                    window.setTimeout(function() {
                                        AdvanceInProgressBar(100);
                                    }, 1000);
                                    $("#ProfilePicture").val(result.Message);
                                    window.setTimeout(function() {
                                        $("#uploadedImage").attr('src', '/storage/images/' + result
                                            .Message);
                                        $("#uploadedframe").removeAttr('hidden');
                                        $("#uploadedImage").removeAttr('hidden');
                                    }, 3000);
                                } else {
                                    window.setTimeout(function() {
                                        $("#UploadMessage").removeAttr('hidden');
                                        $("#UploadMessage").text(result.Message);
                                    }, 3000);
                                }
                            },
                            error: function() {
                                window.setTimeout(function() {
                                    $("#UploadMessage").removeAttr('hidden');
                                    $("#UploadMessage").text('خطا در بارگذاری.لطفا مجدد امتحان کنید');
                                }, 3000);
                            }
                        });
                    } else {
                        window.setTimeout(function() {
                            $("#UploadMessage").removeAttr('hidden');
                            $("#UploadMessage").text('خطا در بارگذاری.فرمت فایل انتخاب شده باید تصویر باشد');
                        }, 3000);
                    }
                    break;
                default:
                    break;
            }
            window.setTimeout(function() {
                $("#UploadModal").modal('hide');
            }, 3000);
        }

        function SearchAll() {
            if ($("#txtSearch").val().length > 0)
                $("#ClearSearch").removeAttr('hidden');
            else
                $("#ClearSearch").attr('hidden', 'hidden');
            $("#txtSearchSm").val($("#txtSearch").val());
            if ($("#txtSearch").val().length > 2)
                ComplexSearch($("#txtSearchSm").val(), 1);
            else {
                $("#SearchResult").html('');
                $("#SearchResultSm").html('');
            }
        }

        function SearchAllSm() {
            if ($("#txtSearchSm").val().length > 0)
                $("#ClearSearchSm").removeAttr('hidden');
            else
                $("#ClearSearchSm").attr('hidden', 'hidden');
            $("#txtSearch").val($("#txtSearchSm").val());
            if ($("#txtSearchSm").val().length > 2)
                ComplexSearch($("#txtSearchSm").val(), 2);
            else {
                $("#SearchResult").html('');
                $("#SearchResultSm").html('');
            }
        }

        function ClearSearchTxt() {
            $("#txtSearch").val('');
            $("#txtSearchSm").val('');
            $("#SearchResult").html('');
            $("#SearchResultSm").html('');
            $("#ClearSearch").attr('hidden', 'hidden');
            $("#ClearSearchSm").attr('hidden', 'hidden');
        }

        function ComplexSearch(textVal, output) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ URL::to('/') }}' + '/complexsearch/' + textVal,
                type: 'get',
                datatype: 'json',
                success: function(result) {
                    if (result.HasValue) {
                        switch (output) {
                            case 1:
                                $("#SearchResult").html(result.Html);
                                break;
                            case 2:
                                $("#SearchResultSm").html(result.Html);
                                break;
                        }
                    } else {
                        $("#SearchResult").html('');
                        $("#SearchResultSm").html('');
                    }
                },
                error: function() {
                    $("#SearchResult").html('');
                    $("#SearchResultSm").html('');
                }
            });
        }

        function CheckForMessages() {
            $.ajax({
                url: '{{ URL::to('/') }}' + '/getrecievemessageneeded/' + $("#txtUserId").text(),
                type: 'get',
                datatype: 'json',
                success: function(result) {
                    if (result.HasValue)
                        GetUsersMessages();
                },
                error: function() {}
            });
        }

        function GetUsersMessages() {
            $.ajax({
                url: '{{ URL::to('/') }}' + '/getmessages/' + $("#txtUserId").text(),
                type: 'get',
                datatype: 'json',
                success: function(result) {
                    if (result.HasValue) {
                        $("#MessagesDrop").html(result.Html);
                        $("#messageCount").text(result.Message);
                    }
                },
                error: function() {}
            });
        }

        function GetUsersAlarms() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ URL::to('/') }}' + '/getalarms/',
                type: 'get',
                datatype: 'json',
                data: {},
                success: function(result) {
                    if (result.HasValue) {
                        $("#AlarmsDropDown").html(result.Html);
                        $("#alarmCount").text(result.Message);
                    }
                },
                error: function() {}
            });
        }

        function ShowDetailModal(typo, Nid) {
            if (typo == 1) {
                $("#DetailModalLabel").text('جزییات اطلاعات محقق');
                $("#btnClose").removeAttr('hidden');
                $("#btnCancel").attr('hidden', 'hidden');
                $("#btnOk").attr('hidden', 'hidden');
                $("#DeleteQuestion").attr('hidden', 'hidden');
                $.ajax({
                    url: '{{ URL::to('/') }}' + '/scholardetail/' + Nid,
                    type: 'get',
                    datatype: 'json',
                    success: function(result) {
                        if (result.HasValue) {
                            $("#DetailModalBody").html(result.Html)
                            $("#DetailModal").modal('show')
                        }
                    },
                    error: function() {}
                });
            } else if (typo == 2) {
                $("#DetailModalLabel").text('جزییات اطلاعات کاربر');
                $("#btnClose").removeAttr('hidden');
                $("#btnCancel").attr('hidden', 'hidden');
                $("#btnOk").attr('hidden', 'hidden');
                $("#DeleteQuestion").attr('hidden', 'hidden');
                $.ajax({
                    url: '{{ URL::to('/') }}' + '/userdetail/' + Nid,
                    type: 'get',
                    datatype: 'json',
                    success: function(result) {
                        if (result.HasValue) {
                            $("#DetailModalBody").html(result.Html)
                            $("#DetailModal").modal('show')
                        }
                    },
                    error: function() {}
                });
            }
        }
    </script>
</body>

</html>
