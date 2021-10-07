<html lang="en">
<head>
    @include('Layouts.Header')
    @yield('styles')
</head>
<body id="page-top">
    <div id="wrapper" style="direction:rtl;">
        {{-- @{
            NPMS_WebUI.ViewModels.SharedLayoutViewModel slvm = new NPMS_WebUI.ViewModels.SharedLayoutViewModel(DataAccessLibrary.Helpers.Encryption.Decrypt(User.Identity.Name).Split(','),0);
            if (HttpContext.Current.Request.Cookies.AllKeys.Contains("NPMS_Permissions"))
            {
                var ticket = FormsAuthentication.Decrypt(HttpContext.Current.Request.Cookies["NPMS_Permissions"].Value);
                slvm.UserPermissions = new NPMS_WebUI.ViewModels.SharedLayoutViewModel(new string[] { ticket.UserData }, 1).UserPermissions;
            }
            else
            {
                slvm.UserPermissions = new List<Guid>();
            }
        } --}}
        <!-- Sidebar -->
        <div class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" style="height:10rem;" href="{{ route('index') }}">
                <div class="sidebar-brand-icon">
                    <img src="{{ URL('Content/img/Logo/logo192.png') }}" style="width:100%;height:10rem;" />
                </div>
            </a>
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            {{-- @if(slvm.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "Dashboard").FirstOrDefault().Id)) --}}
            <div class="nav-item">
                <a class="nav-link" href="{{ route('index') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>داشبورد</span>
                </a>
            </div>
            <!-- Divider -->
            <hr class="sidebar-divider">
            {{-- @endif --}}
            <!-- Heading -->
            <div class="sidebar-heading">
                بخش تحقیقات
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <div class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#ScholarPart"
                   aria-expanded="true" aria-controls="ScholarPart">
                    <i class="fas fa-fw fa-graduation-cap"></i>
                    <span>محقق</span>
                </a>
                <div id="ScholarPart" class="collapse" aria-labelledby="ScholarHeading" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        {{-- @if (slvm.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "AddScholar").FirstOrDefault().Id)) --}}
                            <a class="collapse-item" href="{{ route('scholar.AddScholar') }}" style="text-align:right;">محقق جدید</a>
                        {{-- @endif --}}
                        {{-- @if (slvm.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "Scholars").FirstOrDefault().Id)) --}}
                            <a class="collapse-item" href="{{ route('scholar.Scholars') }}" style="text-align:right;">مدیریت محققان</a>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
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
                        {{-- @*<h6 class="collapse-header"></h6>*@ --}}
                        {{-- @if (slvm.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "AddProject").FirstOrDefault().Id)) --}}
                            <a class="collapse-item" href="{{ route('project.AddProject') }}" style="text-align:right;">طرح جدید</a>
                        {{-- @endif --}}
                        {{-- @if (slvm.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "Projects").FirstOrDefault().Id)) --}}
                            <a class="collapse-item" href="{{ route('project.Projects') }}" style="text-align:right;">مدیریت طرح ها</a>
                        {{-- @endif --}}
                        {{-- @if (slvm.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "ManageProjectsBaseInfo").FirstOrDefault().Id)) --}}
                            <a class="collapse-item" href="{{ route('project.ManageBaseInfo') }}" style="text-align:right;">مدیریت اطلاعات پایه</a>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                بخش گزارشات
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <div class="nav-item collapsed">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#ReportPart" aria-expanded="true"
                   aria-controls="ReportPart">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>گزارشات</span>
                </a>
                <div id="ReportPart" class="collapse" aria-labelledby="ReportHeading"
                     data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        {{-- @*<h6 class="collapse-header">Login Screens:</h6>*@ --}}
                        {{-- @if (slvm.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "StatisticalReports").FirstOrDefault().Id)) --}}
                            <a class="collapse-item" href="{{ route('report.StatisticReports') }}" style="text-align:right;">گزارشات آماری</a>
                        {{-- @endif --}}
                        {{-- @if (slvm.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "ChartReports").FirstOrDefault().Id)) --}}
                            <a class="collapse-item" href="{{ route('report.ChartReports') }}" style="text-align:right;">گزارشات نموداری</a>
                        {{-- @endif --}}
                        {{-- @if (slvm.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "AddCustomReport").FirstOrDefault().Id)) --}}
                            <a class="collapse-item" href="{{ route('report.CustomReports') }}" style="text-align:right;">ایجاد گزارش سفارشی</a>
                        {{-- @endif --}}
                    </div>
                </div>
            </div>
            {{-- @if (slvm.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "AdvanceSearch").FirstOrDefault().Id)) --}}
                            <!-- Nav Item - Charts -->
                <div class="nav-item">
                    <a class="nav-link" href="{{ route('search.AdvanceSearch') }}">
                        <i class="fas fa-fw fa-search"></i>
                        <span>جستجو پیشرفته</span>
                    </a>
                </div>
            <!-- Divider -->
                <hr class="sidebar-divider">
            {{-- @endif --}}
            {{-- @if (slvm.UserLevel == "Admin") --}}
                            <!-- Heading -->
                <div class="sidebar-heading">
                    بخش کاربران
                </div>
            <!-- Nav Item - Pages Collapse Menu -->
                <div class="nav-item collapsed">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#UserPart" aria-expanded="true"
                       aria-controls="UserPart">
                        <i class="fas fa-fw fa-user-circle"></i>
                        <span>کاربر</span>
                    </a>
                    <div id="UserPart" class="collapse" aria-labelledby="UserHeading"
                         data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            {{-- @*<h6 class="collapse-header">Login Screens:</h6>*@ --}}
                            {{-- @if (slvm.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "AddUser").FirstOrDefault().Id)) --}}
                                <a class="collapse-item" href="{{ route('user.AddUser') }}" style="text-align:right;">ایجاد کاربر</a>
                            {{-- @endif --}}
                            {{-- @if (slvm.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "Users").FirstOrDefault().Id)) --}}
                                <a class="collapse-item" href="{{ route('user.Users') }}" style="text-align:right;">مدیریت کاربران</a>
                            {{-- @endif --}}
                            {{-- @if (slvm.UserPermissions.Contains(NPMS_WebUI.ViewModels.SharedLayoutViewModel.ResourceIds.Where(p => p.Title == "UserPermissions").FirstOrDefault().Id)) --}}
                                <a class="collapse-item" href="{{ route('user.UserPermissions') }}" style="text-align:right;">مدیریت دسترسی ها</a>
                            {{-- @endif --}}
                        </div>
                    </div>
                </div>
            <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">
            {{-- @endif --}}
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </div>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
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
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="جستجو ..." id="txtSearch" oninput="SearchAll()"
                                   aria-label="Search" aria-describedby="basic-addon2">
                            <button class="close" type="button" id="ClearSearch" style="padding-left:.5rem;" onclick="ClearSearchTxt()" hidden>
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
                                        <input type="text" class="form-control bg-light border-0 small" id="txtSearchSm" oninput="SearchAllSm()"
                                               placeholder="جستجو..." aria-label="Search"
                                               aria-describedby="basic-addon2">
                                        <button class="close" type="button" id="ClearSearchSm" style="padding-left:.5rem;" onclick="ClearSearchTxt()" hidden>
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
                                @*<a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>*@
                                <a class="dropdown-item text-center small text-gray-500" href="{{ route('alarm.Alarms') }}">نمایش تمامی اعلان ها</a>
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
                                @*<a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="{{ URL('Content/img/undraw_profile_1.svg') }}"
                                             alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">
                                            Hi there! I am wondering if you can help me with a
                                            problem I've been having.
                                        </div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>*@
                                <a class="dropdown-item text-center small text-gray-500" href="{{ route('message.Messages') }}">نمایش تمامی پیام ها</a>
                            </div>
                        </li>
                        <li class="topbar-divider d-none d-sm-block"></li>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="ml-2 d-none d-lg-inline text-gray-600 small">@slvm.UserInfo</span>
                                <span id="txtUserId" hidden >@slvm.NidUser</span>
                                {{-- @if (slvm.HasProfile) --}}
                                    {{-- <img src="@Url.Content("~/ImageTiles/" + slvm.NidUser + ".jpg")" class="img-profile rounded-circle" /> --}}
                                {{-- @endif --}}
                                {{-- @else --}}
                                    <img class="img-profile rounded-circle" src="{{ URL('Content/img/User/user3.png') }}">
                                {{-- @endelse --}}
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-left shadow animated--grow-in"
                                 aria-labelledby="userDropdown" style="max-width:10.375rem !important;">
                                <a class="dropdown-item" href="#" style="text-align:right;">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    پروفایل
                                </a>
                                <a class="dropdown-item" href="#" style="text-align:right;">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    تنظیمات
                                </a>
                                <a class="dropdown-item" href="#" style="text-align:right;">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    گزارش کاربری
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal" style="text-align:right;">
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
    @include('Layouts.Footer')
    @yield('scripts')
</body>
</html>
