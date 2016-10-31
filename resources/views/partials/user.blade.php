<?php
/**
 * Created by PhpStorm.
 * User: SIMON
 * Date: 10.08.2016
 * Time: 15:17
 */

$logged_in          = false;
$user_first_name    = '';
$user_last_name     = '';

if (Auth::check()) {
    $logged_in  = true;
    $user_first_name    = Auth::user()->first_name;
    $user_last_name     = Auth::user()->last_name;
}
?>

@if($logged_in)
<!-- START User Info-->
<div class="visible-lg visible-md m-t-10">
    <div class="pull-left p-r-10 p-t-10 fs-16 font-heading">
        <span class="semi-bold">{{$user_first_name}}</span>
        <span class="text-master">{{$user_last_name}}</span>
    </div>
    <div class="dropdown pull-right">
        <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
            <span class="thumbnail-wrapper d32 circular inline m-t-5">
                <i class="fa fa-user" style="font-size: 20px;"></i>
            </span>
        </button>
        <ul class="dropdown-menu profile-dropdown" role="menu">
            <li><a href="/account"><i class="pg-settings_small"></i> {{trans('menu.user.account')}}</a></li>
            <li><a href="/help"><i class="pg-italic"></i> {{trans('menu.user.help')}}</a></li>
            <li><a href="/contact"><i class="pg-mail"></i> {{trans('menu.user.contact')}}</a></li>
            <li class="bg-master-lighter">
                <a href="/logout" class="clearfix">
                    <span class="pull-left">{{trans('menu.user.logout')}}</span>
                    <span class="pull-right"><i class="pg-power"></i></span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- END User Info-->
@endif