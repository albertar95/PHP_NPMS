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
    <title>ورود</title>
    <!-- Custom fonts for this template-->
    <link href="{{ URL('Content/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL('Content/css/fonts.css') }}" rel="stylesheet" />
    <!-- Custom styles for this template-->
    <link href="{{ URL('Content/css/sb-admin-2.min.css') }}" rel="stylesheet">
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
            <div class="col-xl-10 col-lg-12 col-md-9" style="position: absolute;left:50%;top: 50%;transform: translate(-50%, -50%);padding-left: 3rem;padding-right: 3rem;">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image" style="background:url({{ URL('Content/img/Logo/nepajalogo.png') }});background-size:85% 85%;background-position:center;background-repeat:no-repeat;"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4" style="text-align:center;">ورود به سامانه</h1>
                                    </div>
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" style="text-align:right;width:75%;margin:0 auto;" tabindex="1"
                                                   id="txtUsername" placeholder="نام کاربری">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" style="text-align:right;width:75%;margin:0 auto;" tabindex="2"
                                                   id="txtPassword" placeholder="کلمه عبور">
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block" style="width:75%;margin:0 auto;" id="btnLogin" tabindex="3">ورود</button>
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
    <script src="{{ URL('Content/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ URL('Content/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ URL('Content/js/sb-admin-2.min.js') }}"></script>
    <script type="text/javascript">
        $(function ()
        {
            $("#txtUsername").focus();
            $("#txtPassword").on("keypress", function (e)
            {
                if (e.keyCode == 13)
                    login();
            });
            $("#btnLogin").click(function (e)
            {
                e.preventDefault();
                login();
            });
        });
        function login()
        {
            if($("#txtUsername").val() == '' || $("#txtPassword").val() == '')
            {
                $("#WarningMessage").text('لطفا نام کاربری و رمز عبور خود را وارد نمایید');
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
                        url: '/submitlogin',
                        type: 'post',
                        datatype: 'json',
                        data: { Username: $("#txtUsername").val(), Password: $("#txtPassword").val() },
                        success: function (result)
                        {
                            if (result.HasValue)
                            {
                                $("#loadingTime").removeAttr('hidden');
                                $("#spinnerDiv").removeAttr('hidden');
                                $("#waitText").removeAttr('hidden');
                                $("#FormWrapper").attr('hidden', 'hidden');
                                window.location.href = '/setlogindata/' + result.Message;
                                // $.ajaxSetup({
                                // headers: {
                                // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                // }
                                // });
                                // $.ajax({
                                //     url: 'setlogindata',
                                //     type: 'post',
                                //     datatype: 'json',
                                //     data: { Niduser: result.Message },
                                //     success: function (result) {
                                //         if (result.HasValue) {
                                //             window.location.href = '/';
                                //         }
                                //     },
                                //     error: function () { }
                                // });
                            }
                            else
                            {
                                $("#ErrorMessage").text('ورود ناموفق');
                                $("#errorAlert").removeAttr('hidden');
                                window.setTimeout(function () { $("#errorAlert").attr('hidden', 'hidden') }, 5000);
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
        }
    </script>
</body>
</html>
