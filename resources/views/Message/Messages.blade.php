@extends('Layouts.app')

@section('Content')
{{-- @model NPMS_WebUI.ViewModels.MessageViewModel
@{
    ViewBag.Title = "پیام ها";
    Layout = "~/Views/Shared/_Layout.cshtml";
    NPMS_WebUI.ViewModels.SharedLayoutViewModel slvm = new NPMS_WebUI.ViewModels.SharedLayoutViewModel(DataAccessLibrary.Helpers.Encryption.Decrypt(User.Identity.Name).Split(','), 0);
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

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">پیام ها</h1>
                    </div>
                    <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                        <!-- Card Header - Accordion -->
                        <a href="#collapseSendMessageItems" class="d-block card-header py-3 collapsed" data-toggle="collapse"
                           role="button" aria-expanded="false" aria-controls="collapseSendMessageItems">
                            <h6 class="m-0 font-weight-bold text-primary">ارسال پیام</h6>
                        </a>
                        <!-- Card Content - Collapse -->
                        <div class="collapse" id="collapseSendMessageItems" style="padding:.75rem;">
                            <div class="alert alert-success alert-dismissible" role="alert" id="SuccessAlert" hidden>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <p style="text-align:right;" id="SuccessMessage"></p>
                            </div>
                            <div class="alert alert-warning alert-dismissible" role="alert" id="WarningAlert" hidden>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <p style="text-align:right;" id="WarningMessage"></p>
                            </div>
                            <div class="alert alert-danger alert-dismissible" role="alert" id="ErrorAlert" hidden>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <p style="text-align:right;" id="ErrorMessage"></p>
                            </div>
                            <form class="user" id="SendMessageForm" enctype="application/x-www-form-urlencoded">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <select class="form-control allWidth" data-ng-style="btn-primary" name="RecieverId" style="padding:0 .75rem;">
                                            <option value="0" disabled selected>انتخاب دریافت کننده</option>
                                            @foreach ($Recievers->Where('NidUser','!=','slvm.NidUser')->orderby('LastName') as $rsc)
                                                <option value="{{ $rsc->NidUser }}">{{ $rsc->Username }}<text> ({{ $rsc->FirstName }}&nbsp;{{ $rsc->LastName }}</text></option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" value="" id="NidMessage" name="NidMessage" hidden />
                                        <input type="text" value="@slvm.NidUser" id="SenderId" name="SenderId" hidden />
                                        <input type="text" class="form-control form-control-user" id="Title" name="Title"
                                               placeholder="عنوان">
                                    </div>
                                    <div class="col-sm-6">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <textarea class="form-control" id="MessageContent" name="MessageContent"
                                                  placeholder="متن پیام" rows="5"></textarea>
                                    </div>
                                    <div class="col-sm-6">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <button class="btn btn-primary btn-user btn-block" type="submit" id="btnSendMessage">
                                            ارسال پیام
                                        </button>
                                    </div>
                                    <div class="col-sm-6">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{ $tmpCounter = 1; }}
                    <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                        <!-- Card Header - Accordion -->
                        <a href="#collapseMessagesItems" class="d-block card-header py-3" data-toggle="collapse"
                           role="button" aria-expanded="true" aria-controls="collapseMessagesItems">
                            <h6 class="m-0 font-weight-bold text-primary">پیام های دریافتی</h6>
                        </a>
                        <!-- Card Content - Collapse -->
                        <div class="collapse show" id="collapseMessagesItems" style="padding:.75rem;">
                            <div class="table-responsive" dir="ltr" id="MessagesTableWrapper">
                                <table class="table table-bordered" id="MessagesdataTable" style="width:100%;direction:rtl;text-align:center;" cellspacing="0">
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
                                        @foreach ($Inbox as $msg)
                                            <tr>
                                                <td>{{ $tmpCounter }}</td>
                                                <td>{{ $msg->SenderName }}</td>
                                                <td>{{ $msg->Title }}</td>
                                                <td>{{ $msg->MessageContent }}</td>
                                                <td>
                                                    <a href="{{ link_to_route('message.SingleMessage','',[$NidMessage = $msg->NidMessage,$ReadBy = 1]) }}" class="btn btn-secondary">جزییات پیام</a>
                                                </td>
                                            </tr>
                                            {{ $tmpCounter++; }}
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                        <!-- Card Header - Accordion -->
                        <a href="#collapseSendMessagesItems" class="d-block card-header py-3" data-toggle="collapse"
                           role="button" aria-expanded="true" aria-controls="collapseSendMessagesItems">
                            <h6 class="m-0 font-weight-bold text-primary">پیام های ارسالی</h6>
                        </a>
                        <!-- Card Content - Collapse -->
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
                                        @foreach ($SendMessage as $msg)
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section ('scripts')
    <script type="text/javascript">
        $(function ()
        {
            $("#btnSendMessage").click(function (e)
            {
                e.preventDefault();
                $.ajax(
                    {
                        url: '@Url.Action("SubmitSendMessage", "Home")',
                        type: 'post',
                        datatype: 'json',
                        data: $("#SendMessageForm").serialize(),
                        success: function (result) {
                            if (!result.HasValue) {
                                $("#ErrorMessage").text(result.Message)
                                $("#errorAlert").removeAttr('hidden')
                                window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden'); }, 5000);
                            } else {
                                $("#SuccessMessage").text(result.Message)
                                $("#SuccessAlert").removeAttr('hidden')
                                window.setTimeout(function () { $("#SuccessAlert").attr('hidden', 'hidden'); }, 5000);
                                $('#SendMessageForm').each(function () { this.reset(); });
                                $.ajax(
                                    {
                                        url: '@Url.Action("GetSendMessages", "Home")',
                                        type: 'post',
                                        datatype: 'json',
                                        data: { NidUser: $("#SenderId").val() },
                                        success: function (result) {
                                            if (result.HasValue)
                                                $("#collapseSendMessagesItems").html(result.Html);
                                        },
                                        error: function () {}
                                    });
                            }
                        },
                        error: function () {
                            $("#ErrorMessage").text('خطا در سرور')
                            $("#errorAlert").removeAttr('hidden')
                            window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden'); }, 5000);
                        }
                    });
            });
        });
    </script>
    @endsection


@endsection
