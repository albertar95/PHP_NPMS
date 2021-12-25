<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ URL('Content/img/Icon/icon48.png') }}" />
    <title>تغییر کلمه عبور</title>
    <!-- Custom fonts for this template-->
    <link href="{{ URL('Content/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL('Content/css/fonts.css') }}" rel="stylesheet" />
    <!-- Custom styles for this template-->
    <link href="{{ URL('Content/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ URL('Content/vendor/PasswordStrength/bootstrap-theme.css') }}" rel="stylesheet">
</head>
<body class="bg-gradient-primary" style="background-color:#4e73df;background-image:linear-gradient(180deg,#4e73df 10%,#224abe 100%);">
    <div class="container">
        <div class="d-flex justify-content-center" style="position: absolute;top: 50%;left: 50%;margin-top: -50px;margin-left: -50px;" id="loadingTime" hidden>
            <div class="spinner-border text-info" role="status" style="margin-right:10px;" id="spinnerDiv" hidden>
                <span class="sr-only">...</span>
            </div>
            <div id="waitText" style="color:whitesmoke;font-size:larger;" hidden>
                <span>لطفا منتظر بمانید</span>
            </div>
        </div>
        <!-- Outer Row -->
        <div class="row justify-content-center" id="FormWrapper">
            <div class="col-xl-6 col-lg-10 col-md-8" style="position: absolute;left:50%;top: 50%;transform: translate(-50%, -50%);padding-left: 3rem;padding-right: 3rem;">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-2">
                            </div>
                            <div class="col-lg-10">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4" style="text-align:center;">فرم تغییر کلمه عبور</h1>
                                    </div>
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" style="text-align:right;width:75%;margin:0 auto;" hidden
                                                value="{{ $Niduser }}" id="txtUserId">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" style="text-align:right;width:75%;margin:0 auto;" tabindex="1"
                                                   id="txtOldPassword" placeholder="کلمه عبور فعلی">
                                        </div>
                                        <div class="form-group">
                                            <div>
                                                <input type="password" class="form-control form-control-user" style="text-align:right;width:75%;margin:0 auto;" tabindex="2"
                                                id="txtNewPassword" placeholder="کلمه عبور جدید">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                        <div class="progress progress-striped active" style="width: 75%;margin: auto;">
                                            <div id="jak_pstrength" class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                          </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" style="text-align:right;width:75%;margin:0 auto;" tabindex="3"
                                                   id="txtNewPasswordRepeat" placeholder="تکرار کلمه عبور جدید">
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block" style="width:75%;margin:0 auto;" id="btnSave" tabindex="4">ذخیره</button>
                                        <hr>
                                    </form>
                                </div>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ URL('Content/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/PasswordStrength/jaktutorial.js') }}"></script>
    <script src="{{ URL('Content/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ URL('Content/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ URL('Content/js/sb-admin-2.min.js') }}"></script>
    <script type="text/javascript">
    var passHash = "";
        $(function ()
        {
            jQuery("#txtNewPassword").keyup(function() {
    	    passwordStrength(jQuery(this).val());
    	        });
            $("#txtOldPassword").focus();
            $("#txtNewPasswordRepeat").on("keypress", function (e)
            {
                if (e.keyCode == 13)
                    changeThisPasword();
            });
            $("#btnSave").click(function (e)
            {
                e.preventDefault();
                changeThisPasword();
            });
        });
        function changeThisPasword()
        {
            if($("#txtOldPassword").val() == '' || $("#txtNewPassword").val() == '' || $("#txtNewPasswordRepeat").val() == '')
            {
                $("#WarningMessage").text('لطفا اطلاعات مورد نظر را وارد نمایید');
                $("#warningAlert").removeAttr('hidden');
                window.setTimeout(function () { $("#warningAlert").attr('hidden', 'hidden') }, 5000);
            } else
            {
                $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                $.ajax(
                    {
                        url: '/getuserspasscode/' + $("#txtUserId").val() + '/' + $("#txtOldPassword").val(),
                        type: 'get',
                        datatype: 'json',
                        success: function (result)
                        {
                            if (result.HasValue)
                            {
                                $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                $.ajax(
                    {
                        url: '/submitchangepassword/' + $("#txtUserId").val() + '/' + $("#txtNewPassword").val(),
                        type: 'post',
                        datatype: 'json',
                        success: function (result)
                        {
                            if (result.HasValue)
                            {
                                $("#SuccessMessage").text('کلمه عبور با موفقیت تغییر کرد');
                                $("#successAlert").removeAttr('hidden');
                                window.setTimeout(function () { $("#successAlert").attr('hidden', 'hidden') }, 2000);
                                window.setTimeout(function () { window.location.href = '/login'; }, 3000);
                            }
                            else
                            {
                                if(result.AltProp == "1")
                                {
                                $("#ErrorMessage").text('کلمه عبور جدید قبلا استفاده شده است.لطفا کلمه عبور دیگری انتخاب نمایید');
                                $("#errorAlert").removeAttr('hidden');
                                window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden') }, 5000);
                                }else
                                {
                                $("#ErrorMessage").text('خطا در سرور.لطفا مجدد امتحان کنید');
                                $("#errorAlert").removeAttr('hidden');
                                window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden') }, 5000);
                                }
                            }
                        },
                        error: function ()
                        {
                            $("#ErrorMessage").text('خطا در سرور.لطفا مجدد امتحان کنید');
                            $("#errorAlert").removeAttr('hidden');
                            window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden') }, 5000);
                        }
                    });
                            }
                            else
                            {
                                $("#WarningMessage").text('کلمه عبور فعلی صحیح نمی باشد');
                                $("#warningAlert").removeAttr('hidden');
                                window.setTimeout(function () { $("#warningAlert").attr('hidden', 'hidden') }, 5000);
                            }
                        },
                        error: function ()
                        {
                        }
                    });
            }
        }
    </script>
</body>
</html>
