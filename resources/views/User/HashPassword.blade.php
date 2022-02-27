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
    <title>hash password</title>
    <!-- Custom fonts for this template-->
    <link href="{{ URL('Content/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL('Content/css/fonts.css') }}" rel="stylesheet" />
    <!-- Custom styles for this template-->
    <link href="{{ URL('Content/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body class="bg-gradient-primary"
    style="background-color:#4e73df;background-image:linear-gradient(180deg,#4e73df 10%,#224abe 100%);"
    {{-- style="background:url({{ URL('Content/img/bg.jpg') }});background-size:cover;background-repeat:no-repeat;" --}}>
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center" id="FormWrapper">
            <div class="col-xl-6 col-lg-6 col-md-6"
                style="position: absolute;left:50%;top: 50%;transform: translate(-50%, -50%);padding-left: 3rem;padding-right: 3rem;">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                            </div>
                            <div class="col-lg-8">
                                <div class="text-center">
                                </div>
                            </div>
                            <div class="col-lg-2">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                            </div>
                            <div class="col-lg-8">
                                <div class="p-5">
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                style="text-align:right;width:100%;margin:0 auto;" tabindex="2"
                                                id="txtPassword" placeholder="کلمه عبور">
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block"
                                            style="width:75%;margin:0 auto;" id="btnGenerate" tabindex="3">ایجاد</button>
                                        <div class="form-group">
                                            <textarea id="hashed" class="form-control form-control-user" style="margin-top: 10px;" rows="5"></textarea>
                                        </div>
                                        <hr>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-2">
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
        $(function() {
            $("#txtUsername").focus();
            $("#txtPassword").on("keypress", function(e) {
                if (e.keyCode == 13)
                    login();
            });
            $("#btnGenerate").click(function(e) {
                e.preventDefault();
                generateHash();
            });
        });

        function generateHash() {
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{URL::to('/')}}' + '/submithashpassword',
                    type: 'post',
                    datatype: 'json',
                    data: {
                        Password: $("#txtPassword").val()
                    },
                    success: function(result) {
                        if (result.HasValue) {
                            $("#hashed").text(result.Message);
                        }
                    },
                    error: function() {
                    }
                });
        }
    </script>
</body>

</html>
