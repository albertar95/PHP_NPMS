@extends('Layouts.app')

@section('Content')

<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-6">
        <div class="card shadow border-left-success" style="text-align:right;margin-bottom:1rem;">
            <!-- Card Header - Accordion -->
            <a href="#collapsePersonalInfo" class="d-block card-header py-3 collapsed"
                data-toggle="collapse" role="button" aria-expanded="false"
                aria-controls="collapsePersonalInfo">
                <h6 class="m-0 font-weight-bold text-primary">اطلاعات شخصی</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse" style="padding:.75rem;" id="collapsePersonalInfo">
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-6">
        <div class="card shadow border-left-danger" style="text-align:right;margin-bottom:1rem;">
            <!-- Card Header - Accordion -->
            <a href="#collapseSecurity" class="d-block card-header py-3 collapsed"
                data-toggle="collapse" role="button" aria-expanded="false"
                aria-controls="collapseSecurity">
                <h6 class="m-0 font-weight-bold text-primary">امنیت</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse" style="padding:.75rem;" id="collapseSecurity">
                <div class="card-body">
                    <div class="col-sm-12 col-lg-12" style="display:flex;">
                        <a class="btn btn-outline-primary btn-block" style="margin:1rem;width:25%;" href="changepassword/{{ auth()->user()->NidUser }}"><i class="fa fa-lock"></i> تغییر کلمه عبور</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-6">
        <div class="card shadow border-left-primary" style="text-align:right;margin-bottom:1rem;">
            <!-- Card Header - Accordion -->
            <a href="#collapseUserLog" class="d-block card-header py-3 collapsed"
                data-toggle="collapse" role="button" aria-expanded="false"
                aria-controls="collapseUserLog">
                <h6 class="m-0 font-weight-bold text-primary">گزارش کاربری</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse" style="padding:.75rem;" id="collapseUserLog">
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-6 col-md-6 mb-6">
        <div class="card shadow border-left-warning" style="text-align:right;margin-bottom:1rem;">
            <!-- Card Header - Accordion -->
            <a href="#collapsePermissions" class="d-block card-header py-3 collapsed"
                data-toggle="collapse" role="button" aria-expanded="false"
                aria-controls="collapsePermissions">
                <h6 class="m-0 font-weight-bold text-primary">دسترسی ها</h6>
            </a>
            <!-- Card Content - Collapse -->
            <div class="collapse" style="padding:.75rem;" id="collapsePermissions">
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
