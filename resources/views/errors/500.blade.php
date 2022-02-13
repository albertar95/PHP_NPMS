<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>خطا در سرور</title>
    <link href="{{ URL('Content/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL('Content/css/fonts.css') }}" rel="stylesheet">
    <link href="{{ URL('Content/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary" {{-- style="background-color:#4e73df;background-image:linear-gradient(180deg,#4e73df 10%,#224abe 100%);" --}}
    style="background:url({{ URL('Content/img/bg.jpg') }});background-size:cover;background-repeat:no-repeat;">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center" id="FormWrapper">
            <div class="col-xl-6 col-lg-6 col-md-6"
                style="position: absolute;left:50%;top: 50%;transform: translate(-50%, -50%);padding-left: 3rem;padding-right: 3rem;">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0" style="overflow: hidden;">
                        <!-- Nested Row within Card Body -->
                        <div class="row"
                            style="height: 10rem;background:url({{ URL('Content/img/Logo/nepajalogo.png') }});background-size:contain;background-position:center;background-repeat:no-repeat;">
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                            </div>
                            <div class="col-lg-8">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4" style="text-align:center;">سامانه مدیریت تحقیقات
                                    </h1>
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
                                    <!-- 404 Error Text -->
                                    <div class="text-center">
                                        <div class="error mx-auto" data-text="500">500</div>
                                        <p class="lead text-gray-800 mb-5">خطا در سرور</p>
                                        <p class="text-gray-500 mb-0" style="text-align: center;">خطایی در سرور رخ داده است.لطفا با پشتیبانی تماس بگیرید
                                        </p>
                                        <a href="/">&larr; بازگشت به صفحه اصلی</a>
                                    </div>
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
</body>

</html>
