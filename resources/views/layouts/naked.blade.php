<!DOCTYPE html>
<html>
<head>
@include('layouts.partials.head')
</head>
<body class="fixed-header ">
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-10894705-3', 'auto');
    ga('send', 'pageview');

</script>
<div class="register-container full-height sm-p-t-30">
    <div class="container-sm-height full-height">
        <div class="row row-sm-height">
            <div class="col-sm-12 col-sm-height col-middle">
                @yield('content')
            </div>
        </div>
    </div>
</div>
@include('layouts.partials.scripts')
@section('scripts')
<script>
    $(function()
    {
        $('#form-register').validate()
    })
</script>
@endsection
</body>
</html>