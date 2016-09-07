@extends('layouts.mail')

<?php
if (Auth::check()) {
    $user_first_name    = Auth::user()->first_name;
    $user_last_name     = Auth::user()->last_name;
}
?>

@section('title', 'Hello {{$user_first_name}}')
@section('subtitle', 'Welcome to LeadSpot')

@section('content')
    Your LeadSpot account has been successfully created!<br><br>
    Friendly reminder: LeadSpot is an online tool that aim to help IT services providers to find local business opportunities.
@endsection

@section('action')
    <table class="primary_btn" align="center" border="0" cellspacing="0" cellpadding="0" style="border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;clear: both;margin: 0 auto;">
        <tr>
            <td class="font_default" data-bgcolor="Primary Background" data-color="Buttons &amp; Labels" data-link-color="Buttons &amp; Labels" style="padding: 12px 24px;font-family: Helvetica, Arial, sans-serif;font-size: 16px;mso-line-height-rule: exactly;text-align: center;vertical-align: middle;-webkit-border-radius: 4px;border-radius: 4px;background-color: #666666;">
                <a href="#" data-color="Buttons &amp; Labels" style="display: block;text-decoration: none;font-family: Helvetica, Arial, sans-serif;color: #ffffff;font-weight: bold;text-align: center;">
<span data-color="Buttons &amp; Labels" style="text-decoration: none;color: #ffffff;text-align: center;display: block;">
Button</span>
                </a>
            </td>
        </tr>
    </table>
    <!-- end .primary_btn -->
@endsection