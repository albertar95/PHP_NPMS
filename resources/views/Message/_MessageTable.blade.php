{{-- @model List<DataAccessLibrary.DTOs.MessageDTO> --}}

    {{ $tmpCounter = 1; }}
    <div class="collapse show" id="collapseSendMessagesItems" style="padding:.75rem;">
        <div class="table-responsive" dir="ltr" id="SendMessagesTableWrapper">
            <table class="table table-bordered" id="SendMessagesdataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
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
                    @foreach ($messages as $msg)
                        <tr>
                            <td>{{ $tmpCounter }}</td>
                            <td>{{ $msg->RecieverName }}</td>
                            <td>{{ $msg->Title }}</td>
                            <td>{{ $msg->MessageContent }}</td>
                            <td>
                                <a href="{{ link_to_route('message.SingleMessage','',[$NidMessage = $msg->NidMessage]) }}" class="btn btn-secondary">جزییات پیام</a>
                            </td>
                        </tr>
                        {{ $tmpCounter++; }}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
