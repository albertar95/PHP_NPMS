@extends('Layouts.app')

@section('Content')
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-12">
            <div class="card shadow border-left-primary" style="margin-bottom:1rem;">
                <!-- Card Header - Accordion -->
                <a href="#collapseUserLog" class="d-block card-header py-3" style="text-align: right;" data-toggle="collapse"
                    role="button" aria-expanded="true" aria-controls="collapseUserLog">
                    <h6 class="m-0 font-weight-bold text-primary">گزارش کاربری</h6>
                </a>
                <div class="collapse show" id="collapseUserLog">
                    <div class="card-body">
                        @if (!is_null($logs))
                            <div class="table-responsive" dir="ltr" id="TableContainer">
                                <input type="number" value="1" id="LoadCount" hidden>
                                <table class="table table-bordered" id="userlogdataTable"
                                    style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>تاریخ</th>
                                            <th>زمان</th>
                                            <th>نام کاربری</th>
                                            <th>نوع فعالیت</th>
                                            <th>توضیحات</th>
                                            <th>ای پی</th>
                                            <th>درجه اهمیت</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logs as $lg)
                                            <tr>
                                                <td>{{ $lg->PersianLogDate ?? '' }}</td>
                                                <td>{{ $lg->LogTime ?? '' }}</td>
                                                <td>{{ $lg->Username ?? '' }}</td>
                                                <td>{{ $lg->ActionName ?? '' }}</td>
                                                <td>{{ $lg->Description ?? '' }}</td>
                                                <td>{{ $lg->IP ?? '' }}</td>
                                                @switch($lg->ImportanceLevel)
                                                    @case(1)
                                                        <td>عادی</td>
                                                    @break

                                                    @case(2)
                                                        <td>مهم</td>
                                                    @break

                                                    @case(3)
                                                        <td>خیلی مهم</td>
                                                    @break

                                                    @default
                                                        <td></td>
                                                @endswitch
                                                {{-- <td>{{ $lg->ImportanceLevel ?? '' }}</td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <a rel="nofollow" href="#" id="btnMorePage" style="font-size: 17px;text-align: right;">&plus;
                                نمایش گزارش های
                                بیشتر</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('styles')
        <link href="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
        <title>سامانه مدیریت تحقیقات - گزارش کاربری</title>
    @endsection
    @section('scripts')
        <script src="{{ URL('Content/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ URL('Content/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ URL('Content/js/demo/datatables-demo.js') }}"></script>
        <script type="text/javascript">
            $(function() {
                $('#userlogdataTable').DataTable({
                    "order": [
                        [0, "desc"],
                        [1, "desc"]
                    ],
                });

                $("#btnMorePage").click(function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: '{{ URL::to('/') }}' + '/pagination/5/' + $("#LoadCount").val(),
                        type: 'get',
                        datatype: 'json',
                        success: function(result) {
                            if (result.HasValue == true) {
                                $("#TableContainer").html(result.Html);
                                $('#userlogdataTable').DataTable({
                                    "order": [
                                        [0, "desc"],
                                        [1, "desc"]
                                    ],
                                });
                            } else {
                                $("#btnMorePage").attr('hidden', 'hidden');
                            }
                        },
                        error: function() {}
                    });
                });
            });
        </script>
    @endsection
@endsection
