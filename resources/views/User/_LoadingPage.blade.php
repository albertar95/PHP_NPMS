<!DOCTYPE html>

<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <link href="{{ URL('Content/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL('Content/css/fonts.css') }}" rel="stylesheet">
    <link href="{{ URL('Content/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>
<body id="page-top">
    <input type="text" id="userid" value="@Model" hidden />
    <div class="d-flex justify-content-center" style="position: absolute;top: 50%;left: 50%;margin-top: -50px;margin-left: -50px;" id="loadingTime">
        <div class="spinner-border text-primary" role="status" style="margin-right:10px;" id="spinnerDiv" >
            <span class="sr-only">...</span>
        </div>
        <div id="waitText">
            <span>لطفا منتظر بمانید</span>
        </div>
    </div>
    <script src="{{ URL('Content/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL('Content/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ URL('Content/js/sb-admin-2.min.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            $.ajax(
                {
                    url: '{{URL::to('/')}}' + '/setlogindata',
                    type: 'get',
                    datatype: 'json',
                    data: { Niduser: $("#userid").val() },
                    success: function (result) {
                        if (result.HasValue) {
                            window.location.href = '@Url.Action("Index","Home")';
                        }
                    },
                    error: function () {}
                });
        });
    </script>
</body>
</html>
