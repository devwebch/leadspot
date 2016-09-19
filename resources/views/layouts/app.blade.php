<!DOCTYPE html>
<html>
<head>
    @include('layouts.partials.head')
</head>
<body class="fixed-header">
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-10894705-3', 'auto');
    ga('send', 'pageview');

</script>
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar" data-pages="sidebar">
    <!-- BEGIN SIDEBAR HEADER -->
    <div class="sidebar-header">
        <a href="/"><img src="{{asset('img/logo-leadspot-negative.png')}}"
             alt="LeadSpot"
             class="brand"
             data-src="{{asset('img/logo-leadspot-negative.png')}}"
             data-src-retina="{{asset('img/logo-leadspot-negative.png')}}"
             width="120"></a>
    </div>
    <!-- END SIDEBAR HEADER -->
    <!-- BEGIN SIDEBAR MENU -->
    <div class="sidebar-menu">
        <ul class="menu-items">
            <li class="m-t-30">
                <a href="/" class="detailed">
                    <span class="title">{{trans('menu.dashboard')}}</span>
                </a>
                <span class="icon-thumbnail bg-danger"><i class="pg-home"></i></span>
            </li>
            <li class="">
                <a href="/leads/search">
                    <span class="title">{{trans('menu.search_leads')}}</span>
                </a>
                <span class="icon-thumbnail "><i class="pg-map"></i></span>
            </li>
            <li class="">
                <a href="/leads/list">
                    <span class="title">{{trans('menu.my_leads')}}</span>
                </a>
                <span class="icon-thumbnail "><i class="pg-folder_alt"></i></span>
            </li>
            <li class="m-t-30">
                <a href="/account" class="detailed">
                    <span class="title">{{trans('menu.my_account')}}</span>
                </a>
                <span class="icon-thumbnail"><i class="fa fa-user"></i></span>
            </li>

        </ul>
        <div class="clearfix"></div>
    </div>
    <!-- END SIDEBAR MENU -->
</div>
<!-- END SIDEBAR -->
<!-- START PAGE-CONTAINER -->
<div class="page-container">
    <!-- START PAGE HEADER WRAPPER -->
    <!-- START HEADER -->
    <div class="header ">
        <!-- START MOBILE CONTROLS -->
        <div class="container-fluid relative">
            <!-- LEFT SIDE -->
            <div class="pull-left full-height visible-sm visible-xs">
                <!-- START ACTION BAR -->
                <div class="header-inner">
                    <a href="#" class="btn-link toggle-sidebar visible-sm-inline-block visible-xs-inline-block padding-5" data-toggle="sidebar">
                        <span class="icon-set menu-hambuger"></span>
                    </a>
                </div>
                <!-- END ACTION BAR -->
            </div>
            <div class="pull-center hidden-md hidden-lg">
                <div class="header-inner">
                    <div class="brand inline">
                        <a href="/"><img src="{{asset('img/logo-leadspot.png')}}" 
                             alt="LeadSpot" 
                             data-src="{{asset('img/logo-leadspot.png')}}" 
                             data-src-retina="{{asset('img/logo-leadspot.png')}}"
                             width="78" height="22"></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MOBILE CONTROLS -->
        <div class=" pull-left sm-table hidden-xs hidden-sm">
            <div class="header-inner">
                <div class="brand inline">
                    <a href="/">
                        <img src="{{asset('img/logo-leadspot.png')}}"
                                     alt="LeadSpot"
                                     data-src="{{asset('img/logo-leadspot.png')}}"
                                     data-src-retina="{{asset('img/logo-leadspot.png')}}"
                                     width="130" style="margin-left: 20px;">
                    </a>
                </div>
                <ul class="notification-list no-margin hidden-sm hidden-xs b-grey b-l b-r no-style p-l-30 p-r-20">
                    <li class="p-r-15 inline">
                        <a href="/help"><i class="pg-italic"></i> Help</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class=" pull-right">
            @include('partials.user')
        </div>
    </div>
    <!-- END HEADER -->
    <!-- END PAGE HEADER WRAPPER -->
    <!-- START PAGE CONTENT WRAPPER -->
    <div class="page-content-wrapper">
        <!-- START PAGE CONTENT -->
        <div class="content">
            <!-- START JUMBOTRON -->
            <div class="jumbotron" data-pages="parallax">
                <div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">
                    <div class="inner">
                        <!-- START BREADCRUMB -->
                        <ul class="breadcrumb">
                            <li><p><a href="/">HOME</a></p></li>
                            @yield('breadcrumb')
                        </ul>
                        <!-- END BREADCRUMB -->
                    </div>
                </div>
            </div>
            <!-- END JUMBOTRON -->
            <!-- START CONTAINER FLUID -->
            <div class="container-fluid container-fixed-lg">
                <!-- BEGIN PlACE PAGE CONTENT HERE -->
                @yield('content')
                <!-- END PLACE PAGE CONTENT HERE -->
            </div>
            <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->
        <!-- START FOOTER -->
        <div class="container-fluid container-fixed-lg footer">
            <div class="copyright sm-text-center">
                <p class="small no-margin pull-left sm-pull-reset">
                    <span class="hint-text">Copyright © 2016</span>
                    <span class="font-montserrat">LeadSpot</span>.
                    <span class="hint-text">All rights reserved.</span>
                    <span class="sm-block"><a href="http://leadspotapp.com/terms-and-conditions" target="_blank" class="m-l-10 m-r-10">Terms of use</a> | <a href="#" class="m-l-10">Privacy Policy</a>
                        </span>
                </p>
                <p class="small no-margin pull-right sm-pull-reset p-l-20">
                    <span class="hint-text">V 0.5</span>
                </p>
                <p class="small no-margin pull-right sm-pull-reset">
                    <span>Made in </span>
                    <span class="hint-text">Switzerland</span>
                </p>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- END FOOTER -->
    </div>
    <!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTAINER -->
@include('layouts.partials.scripts')
</body>
</html>