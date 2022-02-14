@extends('Layouts.app')

@section('Content')
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-12">
            <div class="card shadow border-left-primary" style="margin-bottom:1rem;">
                <!-- Card Header - Accordion -->
                <a href="#collapseUserLog" class="d-block card-header py-3" style="text-align: right;" data-toggle="collapse" role="button"
                    aria-expanded="true" aria-controls="collapseUserLog">
                    <h6 class="m-0 font-weight-bold text-primary">گزارش کاربری</h6>
                </a>
                <div class="collapse show" id="collapseUserLog">
                    <div class="card-body">
                        @if (!is_null($logs))
                            <div class="table-responsive" dir="ltr">
                                <table class="table table-bordered" id="userlogdataTable"
                                    style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>تاریخ</th>
                                            <th>زمان</th>
                                            <th>نام کاربری</th>
                                            <th>توضیحات</th>
                                            <th>درجه اهمیت</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($logs as $lg)
                                            <tr>
                                                <td>{{ $lg->LogDate ?? '' }}</td>
                                                <td>{{ $lg->LogTime ?? '' }}</td>
                                                <td>{{ $lg->Username ?? '' }}</td>
                                                <td>{{ $lg->Description ?? '' }}</td>
                                                <td>{{ $lg->ImportanceLevel ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
    $(function()
    {
        $('#userlogdataTable').DataTable( {
                    "order": [[ 0, "desc" ],[ 1, "desc" ]],
                } );
    });
    </script>
@endsection
@endsection
