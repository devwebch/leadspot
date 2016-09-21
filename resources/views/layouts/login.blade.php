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
<div class="login-wrapper ">
    <!-- START Login Background Pic Wrapper-->
    <div class="bg-pic hidden-xs">
        <!-- START Background Caption-->
        <div class="bg-caption pull-bottom sm-pull-bottom text-white p-l-20 m-b-20">
            <h2 class="semi-bold text-white">{{trans('login.catchphrase')}}</h2>
            <p class="small">{{trans('login.copyright')}}</p>
        </div>
        <!-- END Background Caption-->
    </div>
    <!-- END Login Background Pic Wrapper-->
    <!-- START Login Right Container-->
    <div class="login-container bg-white">
        <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
            <img src="{{asset('img/logo-leadspot.png')}}" alt="logo" data-src="{{asset('img/logo-leadspot.png')}}" data-src-retina="{{asset('img/logo-leadspot.png')}}" width="200">
            <p class="p-t-10">{{trans('login.form_intro')}}</p>
            <!-- START Login Form -->
            @yield('content')
            <!--END Login Form-->
            <div class="pull-bottom sm-pull-bottom">
                <div class="m-b-30 p-r-80 sm-m-t-20 sm-p-r-15 sm-p-b-20 clearfix">
                    <div class="col-sm-12 no-padding m-t-10">
                        <strong>{{trans('login.have_account')}}</strong>
                        <p>
                            <small>
                                <a href="/register">{{trans('login.create_account')}}</a>
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Login Right Container-->
</div>
@include('layouts.partials.scripts')
@section('scripts')
<script>
    $(function()
    {
        $('#form-login').validate()
    })
</script>
@endsection
</body>
</html>