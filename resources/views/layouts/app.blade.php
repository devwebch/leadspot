<!DOCTYPE html>
<html>
<head>
    @include('layouts.partials.head')
</head>
<body class="fixed-header menu-pin-nope">
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar" data-pages="sidebar">
    <!-- BEGIN SIDEBAR HEADER -->
    <div class="sidebar-header">
        <a href="/"><img src="{{asset('assets/img/logo-leadspot-negative.png')}}"
             alt="LeadSpot"
             class="brand"
             data-src="{{asset('assets/img/logo-leadspot-negative.png')}}"
             data-src-retina="{{asset('assets/img/logo_white2x.png')}}"
             width="120"></a>
    </div>
    <!-- END SIDEBAR HEADER -->
    <!-- BEGIN SIDEBAR MENU -->
    <div class="sidebar-menu">
        <ul class="menu-items">
            <li class="m-t-30">
                <a href="/" class="detailed">
                    <span class="title">Dashboard</span>
                </a>
                <span class="icon-thumbnail "><i class="pg-home"></i></span>
            </li>
            <li class="">
                <a href="/leads/search">
                    <span class="title">Search leads</span>
                </a>
                <span class="icon-thumbnail "><i class="pg-map"></i></span>
            </li>
            <li class="">
                <a href="/leads/list">
                    <span class="title">My Leads</span>
                </a>
                <span class="icon-thumbnail "><i class="pg-folder_alt"></i></span>
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
                        <a href="/"><img src="{{asset('assets/img/logo-leadspot.png')}}" 
                             alt="LeadSpot" 
                             data-src="{{asset('assets/img/logo-leadspot.png')}}" 
                             data-src-retina="{{asset('assets/img/logo_2x.png')}}" 
                             width="78" height="22"></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MOBILE CONTROLS -->
        <div class=" pull-left sm-table hidden-xs hidden-sm">
            <div class="header-inner">
                <div class="brand inline">
                    <a href="/"><img src="{{asset('assets/img/logo-leadspot.png')}}"
                         alt="LeadSpot" data-src="{{asset('assets/img/logo-leadspot.png')}}" data-src-retina="{{asset('assets/img/logo_2x.png')}}" width="120"></a>
                </div>
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
                    <span class="sm-block"><a href="#" class="m-l-10 m-r-10">Terms of use</a> | <a href="#" class="m-l-10">Privacy Policy</a>
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