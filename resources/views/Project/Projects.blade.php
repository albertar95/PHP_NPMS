@extends('Layouts.app')

@section('Content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary" style="text-align:right;">مدیریت طرح ها</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-success alert-dismissible" role="alert" id="successAlert" hidden>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p style="text-align:right;" id="SuccessMessage"></p>
            </div>
            <div class="alert alert-warning alert-dismissible" role="alert" id="warningAlert" hidden>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p style="text-align:right;" id="WarningMessage"></p>
            </div>
            <div class="alert alert-danger alert-dismissible" role="alert" id="errorAlert" hidden>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p style="text-align:right;" id="ErrorMessage"></p>
            </div>
            @if(in_array('2',$sharedData['UserAccessedEntities']))
                @if(explode(',',$sharedData['UserAccessedSub']->where('entity','=',2)->pluck('rowValue')[0])[0] == 1)
                <a class="btn btn-outline-success btn-block" style="margin:1rem;width:15%;" href="/addproject">ایجاد طرح</a>
                @endif
            @endif
            <div class="table-responsive" dir="ltr">
                <table class="table table-bordered" id="dataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                    <thead>
                        <tr>
                            <th>شماره پرونده</th>
                            <th>نام محقق</th>
                            <th>موضوع</th>
                            <th class="priority-1">یگان</th>
                            <th class="priority-2">گروه</th>
                            <th class="priority-3">وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>شماره پرونده</th>
                            <th>نام محقق</th>
                            <th>موضوع</th>
                            <th class="priority-1">یگان</th>
                            <th class="priority-2">گروه</th>
                            <th class="priority-3">وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($Projects as $prj)
                            <tr>
                                <td>{{ $prj->ProjectNumber }}</td>
                                <td>{{ $prj->ScholarName }}</td>
                                <td>{{ $prj->Subject }}</td>
                                <td class="priority-1">{{ $prj->UnitName }}</td>
                                <td class="priority-2">{{ $prj->GroupName }}</td>
                                <td>
                                    <div class="chart-pie" style="width:50px;margin:0 auto;">
                                        <canvas id="{{ $prj->NidProject }}" title="{{ $prj->ProjectStatus }}"></canvas>
                                    </div>
                                </td>
                                <td>
                                @if(in_array('2',$sharedData['UserAccessedEntities']))
                                    @if(explode(',',$sharedData['UserAccessedSub']->where('entity','=',2)->pluck('rowValue')[0])[3] == 1)
                                    <a href="/projectdetail/{{ $prj->NidProject }}" class="btn btn-secondary">جزییات</a>
                                    @endif
                                @endif
                                @if(in_array('2',$sharedData['UserAccessedEntities']))
                                    @if(explode(',',$sharedData['UserAccessedSub']->where('entity','=',2)->pluck('rowValue')[0])[1] == 1)
                                    <a href="/projectprogress/{{ $prj->NidProject }}" class="btn btn-info">پیشرفت</a>
                                    @endif
                                @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @section ('styles')
        <link href="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @endsection
    @section ('scripts')
        <script src="{{ URL('Content/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ URL('Content/js/demo/datatables-demo.js') }}"></script>
        <script src="{{ URL('Content/vendor/chart.js/Chart.min.js') }}"></script>
        <script src="{{ URL('Content/vendor/chart.js/Chart.bundle.min.js') }}"></script>
        <script type="text/javascript">
            $(function ()
            {
                // Set new default font family and font color to mimic Bootstrap's default styling
                Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                Chart.defaults.global.defaultFontColor = '#858796';
                //ShowStatus('myPieChart', 10);
                $(".chart-pie canvas").each(function () {
                    ShowStatus($(this).prop('id'), $(this).prop('title'));
                });
            });
            function ShowStatus(CanvasId,PercentageVal)
            {
                var ctx = document.getElementById(CanvasId);
                var myPieChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ["on", "off"],
                        datasets: [{
                            data: [PercentageVal, 100 - PercentageVal],
                            backgroundColor: ['#1cc88a', '#e3e3e3'],
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        tooltips: {
                            enabled: false
                        },
                        legend: {
                            display: false
                        },
                        cutoutPercentage: 80,
                        animation:
                            {
                                onComplete: function () {
                                    var ctx2 = ctx.getContext("2d");
                                    ctx2.textAlign = 'center';
                                    ctx2.textBaseline = 'middle';
                                    ctx2.font = '14px verdana';
                                    ctx2.fillStyle = '#858796';
                                    ctx2.fillText(PercentageVal + "%", 25, 24);
                                }
                            }
                    },
                });
            }
        </script>
    @endsection
@endsection
