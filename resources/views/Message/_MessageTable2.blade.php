<input type="number" value="{{ $txtLoadCount }}" id="LoadCount2" hidden>
<table class="table table-bordered" id="MessagesdataTable"
    style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
    <thead>
        <tr>
            <th>ردیف</th>
            <th>ارسال کننده</th>
            <th>عنوان</th>
            <th>پیام</th>
            <th>عملیات</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>ردیف</th>
            <th>ارسال کننده</th>
            <th>عنوان</th>
            <th>پیام</th>
            <th>عملیات</th>
        </tr>
    </tfoot>
    <tbody>
        @if (in_array('5', $sharedData['UserAccessedEntities']))
            @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 5)->pluck('rowValue')[0])[4] == 1)
                @foreach ($Inbox as $key => $msg)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $msg->SenderName }}</td>
                        <td
                            style=" max-width: 150px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                            {{ $msg->Title }}</td>
                        <td
                            style=" max-width: 120px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">
                            {{ $msg->MessageContent }}</td>
                        <td>
                            @if (in_array('5', $sharedData['UserAccessedEntities']))
                                @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 5)->pluck('rowValue')[0])[3] == 1)
                                    <a href="{{ sprintf("%s/%s/1",URL::to('/singlemessage'),$msg->NidMessage) }}"
                                        class="btn btn-info btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <span class="text">جزییات</span>
                                    </a>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        @endif
    </tbody>
</table>
