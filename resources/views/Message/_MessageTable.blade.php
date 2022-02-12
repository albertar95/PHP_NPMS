{{-- @model List<DataAccessLibrary.DTOs.MessageDTO> --}}

<div class="collapse show" id="collapseSendMessagesItems" style="padding:.75rem;">
    <div class="table-responsive" dir="ltr" id="SendMessagesTableWrapper">
        <table class="table table-bordered" id="SendMessagesdataTable"
            style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
            <thead>
                <tr>
                    <th>ردیف</th>
                    <th>دریافت کننده</th>
                    <th>عنوان</th>
                    <th>پیام</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ردیف</th>
                    <th>دریافت کننده</th>
                    <th>عنوان</th>
                    <th>پیام</th>
                    <th>عملیات</th>
                </tr>
            </tfoot>
            <tbody>
                @if (in_array('5', $sharedData['UserAccessedEntities']))
                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 5)->pluck('rowValue')[0])[4] == 1)
                        @foreach ($messages as $key => $msg)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $msg->RecieverName }}</td>
                                <td>{{ $msg->Title }}</td>
                                <td>{{ $msg->MessageContent }}</td>
                                <td>
                                    @if (in_array('5', $sharedData['UserAccessedEntities']))
                                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 5)->pluck('rowValue')[0])[3] == 1)
                                            <a href="/singlemessage/{{ $msg->NidMessage }}/0"
                                                class="btn btn-secondary">جزییات
                                                پیام</a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endif
            </tbody>
        </table>
    </div>
</div>
