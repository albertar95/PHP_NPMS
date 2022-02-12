@extends('Layouts.app')

@section('Content')

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="p-5">
                        <div class="card shadow" style="text-align:right;margin-bottom:1rem;">
                            <!-- Card Header - Accordion -->
                            <a href="#collapseSendMessageItems" class="d-block card-header py-3"
                                data-toggle="collapse" role="button" aria-expanded="true"
                                aria-controls="collapseSendMessageItems">
                                <h6 class="m-0 font-weight-bold text-primary">ارسال پیام</h6>
                            </a>
                            <!-- Card Content - Collapse -->
                            <div class="collapse show" id="collapseSendMessageItems" style="padding:.75rem;">
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
                                @if (in_array('5', $sharedData['UserAccessedEntities']))
                                    @if (explode(',', $sharedData['UserAccessedSub']->where('entity', '=', 5)->pluck('rowValue')[0])[0] == 1)
                                        <form class="user" id="SendMessageForm"
                                            enctype="application/x-www-form-urlencoded">
                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <select class="form-control allWidth" data-ng-style="btn-primary"
                                                        name="RecieverId" id="RecieverId" style="padding:0 .75rem;">
                                                        <option value="0" selected>انتخاب دریافت کننده</option>
                                                        @foreach ($Recievers->Where('NidUser', '!=', auth()->user()->NidUser )->sortBy('LastName') as $rsc)
                                                            <option value="{{ $rsc->NidUser }}">
                                                                <i style="direction: rtl;text-align: right;">{{ $rsc->Username }} ({{ $rsc->FirstName }} {{ $rsc->LastName }})</i>
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="text" value="" id="NidMessage" name="NidMessage" hidden />
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
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@section('scripts')
    <script type="text/javascript">
    var ValiditiyMessage = "";
        $(function() {
            $("#btnSendMessage").click(function(e) {
                e.preventDefault();
                if(CheckInputValidity())
                {
                    $.ajax({
                    url: '/submitsendmessage',
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
                            $("#SuccessMessage").text(result.Message)
                            $("#SuccessAlert").removeAttr('hidden')
                            window.setTimeout(function() {
                                $("#SuccessAlert").attr('hidden', 'hidden');
                            }, 5000);
                            $('#SendMessageForm').each(function() {
                                this.reset();
                            });
                            window.setTimeout(function() {
                                window.location.href = '/messages/' + $("#SenderId").val();
                            }, 3000);
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
                }else
                {
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
