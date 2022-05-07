@extends('Layouts.app')

@section('Content')
    {{-- @model NPMS_WebUI.ViewModels.MessageViewModel
@{
    ViewBag.Title = "SingleMessage";
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
                            <h1 class="h4 text-gray-900 mb-4">پیام</h1>
                        </div>
                        <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                            <!-- Card Header - Accordion -->
                            <a href="#collapseSendMessageItems" class="d-block card-header py-3" data-toggle="collapse"
                                role="button" aria-expanded="true" aria-controls="collapseSendMessageItems">
                                <h6 class="m-0 font-weight-bold text-primary">جزییات پیام</h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse show" id="collapseSendMessageItems" style="padding:.75rem;">
                                <form class="user" id="SendMessageForm"
                                    enctype="application/x-www-form-urlencoded">
                                    @foreach ($Inbox->sortBy('CreateDate') as $msg)
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0" style="display:flex;">
                                                <label style="padding-top:.8rem;">فرستنده : </label>
                                                <input type="text" class="form-control form-control-user"
                                                    value="{{ $msg->SenderName }}" readonly>
                                            </div>
                                            <div class="col-sm-6" style="display:flex;">
                                                <label style="padding-top:.8rem;">گیرنده : </label>
                                                <input type="text" class="form-control form-control-user"
                                                    value="{{ $msg->RecieverName }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0" style="display:flex;">
                                                <label style="padding-top:.8rem;">عنوان پیام : </label>
                                                <input type="text" class="form-control form-control-user"
                                                    value="{{ $msg->Title }}" readonly>
                                            </div>
                                            <div class="col-sm-6" style="display:flex;">
                                                <label style="padding-top:.8rem;">تاریخ : </label>
                                                <input type="text" class="form-control form-control-user"
                                                    value="{{ $msg->PersianCreateDate }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12 mb-3 mb-sm-0">
                                                <textarea class="form-control" readonly placeholder="متن پیام"
                                                    rows="5">{{ $msg->MessageContent }}</textarea>
                                            </div>
                                        </div>
                                        <hr style="border-top: 1px solid rgba(0, 0, 0, 0.25);" />
                                    @endforeach
                                    @if (in_array('5', $sharedData['UserAccessedEntities']))
                                        @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 5)->pluck('rowValue')[0])[0] == 1)
                                            <h2 style="padding:2rem;">ارسال پاسخ پیام</h2>
                                            <div class="alert alert-success alert-dismissible" role="alert" id="SuccessAlert" hidden>
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <p style="text-align:right;" id="SuccessMessage"></p>
                                            </div>
                                            <div class="alert alert-warning alert-dismissible" role="alert" id="WarningAlert" hidden>
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <p style="text-align:right;" id="WarningMessage"></p>
                                            </div>
                                            <div class="alert alert-danger alert-dismissible" role="alert" id="ErrorAlert" hidden>
                                                <button type="button" class="close" data-dismiss="alert"
                                                    aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <p style="text-align:right;" id="ErrorMessage"></p>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="text" class="form-control form-control-user"
                                                        id="RecieverId" name="RecieverId"
                                                        value="{{ $SingleMessage->SenderId }}" readonly hidden
                                                        placeholder="دریافت کننده">
                                                </div>
                                                <div class="col-sm-6">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="text" class="form-control form-control-user"
                                                        value="{{ $SingleMessage->NidMessage }}" id="NidCurrentMessage"
                                                        hidden>
                                                    <input type="text" value="{{ $readby }}" id="ReadBy" hidden>
                                                    <input type="text" value="" id="NidMessage" name="NidMessage" hidden />
                                                    <input type="text" value="{{ $SingleMessage->NidMessage }}"
                                                        id="RelatedId" name="RelatedId" hidden />
                                                    <input type="text" value="{{ auth()->user()->NidUser }}" id="SenderId"
                                                        name="SenderId" hidden />
                                                    <input type="text" class="form-control form-control-user" id="Title"
                                                        name="Title" placeholder="عنوان">
                                                </div>
                                                <div class="col-sm-6">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <textarea class="form-control" id="MessageContent"
                                                        name="MessageContent" placeholder="متن پیام" rows="5"></textarea>
                                                </div>
                                                <div class="col-sm-6">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <button class="btn btn-primary btn-user btn-block" type="submit"
                                                        id="btnSendMessage">
                                                        ارسال پیام
                                                    </button>
                                                </div>
                                                <div class="col-sm-6">
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('styles')
<title>سامانه مدیریت تحقیقات - پیام</title>
@endsection
@section('scripts')
    <script type="text/javascript">
        var ValiditiyMessage = "";
        $(function() {
            if ($("#ReadBy").val() == 1) {
                $.ajax({
                    url: '{{URL::to('/')}}' + '/readmessage/' + $("#NidCurrentMessage").val(),
                    type: 'get',
                    datatype: 'json',
                    success: function() {},
                    error: function() {}
                });
            }
            $("#btnSendMessage").click(function(e) {
                e.preventDefault();
                if (CheckInputValidity()) {
                    $.ajax({
                        url: '{{URL::to('/')}}' + '/submitsendmessage',
                        type: 'post',
                        datatype: 'json',
                        data: $("#SendMessageForm").serialize(),
                        success: function(result) {
                            if (!result.HasValue) {
                                $("#ErrorMessage").text(result.Message)
                                $("#errorAlert").removeAttr('hidden')
                                window.setTimeout(function() {
                                    $("#errorAlert").attr('hidden', 'hidden');
                                }, 5000);
                            } else {
                                location.reload();
                            }
                        },
                        error: function(response) {
                            var message = "<ul>";
                            jQuery.each(response.responseJSON.errors, function(i, val) {
                                message += "<li>";
                                message += val;
                                message += "</li>";
                            });
                            message += "</ul>";
                            $("#ErrorMessage").html(message)
                            // $("#ErrorMessage").text('خطا در انجام عملیات.لطفا مجددا امتحان کنید')
                            $("#ErrorAlert").removeAttr('hidden')
                            window.setTimeout(function() {
                                $("#ErrorAlert").attr('hidden', 'hidden');
                            }, 5000);
                        }
                    });
                } else {
                    $("#ErrorMessage").html(ValiditiyMessage)
                    $("#ErrorAlert").removeAttr('hidden')
                    window.setTimeout(function() {
                        $("#ErrorAlert").attr('hidden', 'hidden');
                    }, 5000);
                    ValiditiyMessage = "";
                }
            });
        });

        function CheckInputValidity() {
            var isValid = true;
            if (!$("#Title").val()) {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "عنوان پیام وارد نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            if (!$("#MessageContent").val()) {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "متن پیام وارد نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            if ($("#RecieverId").val() == "0") {
                ValiditiyMessage += '<li>';
                ValiditiyMessage += "گیرنده انتخاب نشده است";
                ValiditiyMessage += '</li>';
                isValid = false;
            }
            ValiditiyMessage = "<ul>" + ValiditiyMessage + "</ul>";
            return isValid;
        }
    </script>
@endsection


@endsection
