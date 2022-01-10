@extends('Layouts.app')

@section('Content')
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <i class="fas fa-spinner fa-2x text-gray-300"></i>
                        </div>
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                تعداد طرح های در حال انجام</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $briefs[3] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <i class="fas fa-check fa-2x text-gray-300"></i>
                        </div>
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                تعداد طرح های تکمیل شده</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $briefs[2] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <i class="fas fa-file fa-2x text-gray-300"></i>
                        </div>
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">تعداد طرح ثبت شده
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $briefs[1] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                        </div>
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                تعداد محققین ثبت شده</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $briefs[0] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">گزارش نموداری طرح های ثبت شده به تفکیک ماه</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <input type="text" value="{{ $chartvals }}" id="txtChartVals" hidden />
                    <div class="chart-area">
                        <canvas id="projectsAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-6 mb-4">

            <!-- Illustrations -->
            <div class="card shadow mb-4">
                <div class="card-header py-3" style="text-align: right;">
                    <h6 class="m-0 font-weight-bold text-primary">پیام ها</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="MessagedataTable"
                        style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ردیف</th>
                                <th>عنوان</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ردیف</th>
                                <th>عنوان</th>
                                <th>عملیات</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                    <a target="_blank" rel="nofollow" href="https://undraw.co/">مشاهده تمامی پیام ها &larr;</a>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">

            <!-- Illustrations -->
            <div class="card shadow mb-4">
                <div class="card-header py-3" style="text-align: right;">
                    <h6 class="m-0 font-weight-bold text-primary">اعلان ها</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="AlarmdataTable"
                        style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                        <thead>
                            <tr>
                                <th>عنوان</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>عنوان</th>
                                <th>عملیات</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($alarms as $alm)
                            <tr>
                            @switch ($alm->AlarmSubject)
                                @case ('PreImployment')
                                <td>
                                    <span class="font-weight-bold">{{ sprintf("%d پروژه نامه روگرفتشان دریافت نشده است",$alm->Description) }}</span>
                                </td>
                                <td>
                                    <a class="btn btn-secondary" href="/alarms/1">مشاهده
                                    </a>
                                </td>
                                    @break
                                @case ('SecurityLetter')
                                    <td>
                                        <span class="font-weight-bold">{{ sprintf("%d پروژه نامه حفاظت شان دریافت نشده است",$alm->Description) }}</span>
                                    </td>
                                    <td>
                                        <a class="btn btn-secondary" href="/alarms/2">مشاهده
                                        </a>
                                    </td>
                                    @break
                                @case ('ThirtyLetter')
                                <td>
                                    <span class="font-weight-bold">{{ sprintf("%d پروژه فرم 30 درصدشان دریافت نشده است",$alm->Description) }}</span>
                                </td>
                                <td>
                                    <a class="btn btn-secondary" href="/alarms/3">مشاهده
                                    </a>
                                </td>
                                    @break
                                @case ('SixtyLetter')
                                <td>
                                    <span class="font-weight-bold">{{ sprintf("%d پروژه فرم 60 درصدشان دریافت نشده است",$alm->Description) }}</span>
                                </td>
                                <td>
                                    <a class="btn btn-secondary" href="/alarms/4">مشاهده
                                    </a>
                                </td>
                                    @break
                                @case ('ThesisLetter')
                                <td>
                                    <span class="font-weight-bold">{{ sprintf("%d پروژه دفاعیه شان برگزار نشده است",$alm->Description) }}</span>
                                </td>
                                <td>
                                    <a class="btn btn-secondary" href="/alarms/5">مشاهده
                                    </a>
                                </td>
                                    @break
                                @case ('RefInfo')
                                <td>
                                    <span class="font-weight-bold">{{ sprintf("%d پروژه داور 1 و 2 شان مشخص نشده است",$alm->Description) }}</span>
                                </td>
                                <td>
                                    <a class="btn btn-secondary" href="/alarms/6">مشاهده
                                    </a>
                                </td>
                                    @break
                                @case ('EditorInfo')
                                <td>
                                    <span class="font-weight-bold">{{ sprintf("%d پروژه ویراستارشان مشخص نشده است",$alm->Description) }}</span>
                                </td>
                                <td>
                                    <a class="btn btn-secondary" href="/alarms/7">مشاهده
                                    </a>
                                </td>
                                    @break
                                @case ('AdvSupInfo')
                                <td>
                                    <span class="font-weight-bold">{{ sprintf("%d پروژه استاد راهنما و مشاورشان مشخص نشده است",$alm->Description) }}</span>
                                </td>
                                <td>
                                    <a class="btn btn-secondary" href="/alarms/8">مشاهده
                                    </a>
                                </td>
                                    @break
                            @endswitch
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <a target="_blank" rel="nofollow" href="https://undraw.co/">مشاهده تمامی اعلان ها &larr;</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL('Content/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ URL('Content/js/demo/chart-area-demo.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            let refer = document.referrer;
            if (refer.includes('login')) {
                $('#EnteranceModal').modal('show');
            }
            AreaChartDemostration($("#txtChartVals").val());
        });

        function AreaChartDemostration(vals) {
            const Svals = vals.split(',');
            var ctx = document.getElementById("projectsAreaChart");
            var myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["فروردین", "اردیبهشت", "خرداد", "تیر", "مرداد", "شهریور", "مهر", "آبان", "آذر", "دی",
                        "بهمن",
                        "اسفند"
                    ],
                    datasets: [{
                        label: "تعداد طرح",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "rgba(78, 115, 223, 1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointBorderColor: "rgba(78, 115, 223, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: [Svals[0], Svals[1], Svals[2], Svals[3], Svals[4], Svals[5], Svals[6], Svals[
                            7], Svals[8], Svals[9], Svals[10], Svals[11]],
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 10,
                            right: 25,
                            top: 25,
                            bottom: 0
                        }
                    },
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'date'
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 7
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                maxTicksLimit: 5,
                                padding: 10,
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }],
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: 'index',
                        caretPadding: 10,
                        callbacks: {
                            label: function(tooltipItem, chart) {
                                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                            }
                        }
                    }
                }
            });
        }
    </script>
@endsection
