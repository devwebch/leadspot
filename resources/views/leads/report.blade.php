@extends('layouts.empty')

@section('styles')
    <link href="plugins/bootstrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            font-size: 12px;
            font-family: "Segoe UI", "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: "Segoe UI", "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        h1 { font-size: 26px; }
        h2 { font-size: 22px; }
        h3 { font-size: 18px; }
        h4 { font-size: 16px; }

        table {
            width: 100%;
        }

        table tr td {
            border-width: 1px;
            vertical-align: top;
        }

        .report {

        }
        .report .header {
            border: none;
            margin-bottom: 40px;
        }
    </style>
@endsection

@section('content')
    <div class="panel">
        <div class="panel-body">

            <div class="report">
                <div class="header">
                    <img src="img/logo-leadspot.png" alt="LeadSpot" width="180">
                </div>

                <h1>{{$lead->name}}</h1>
                <h4>{{$lead->address}}</h4>

                <table class="table" style="margin-top: 20px;">
                    <tbody>
                        <tr>
                            <td><strong>Website</strong></td>
                            <td>{{$lead->url}}</td>
                        </tr>
                        <tr>
                            <td><strong>CMS</strong></td>
                            <td>{{config('constants.cms.' . $lead->cms)}}</td>
                        </tr>
                        <tr>
                            <td><strong>Phone</strong></td>
                            <td>{{$lead->phone_number}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h3>Notes</h3>
                                <p>{{$lead->notes}}</p>
                            </td>
                        </tr>
                        <tr>
                            <td width="45%">
                                <h3>Obsolescence indicators</h3>
                                <table class="table">
                                    <tr>
                                        <td>
                                            <strong>Responsive</strong>
                                        </td>
                                        <td>Yes</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>GZIP</strong>
                                        </td>
                                        <td>Yes</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Minified CSS</strong></td>
                                        <td>No</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Minified JS</strong></td>
                                        <td>No</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Minified HTML</strong></td>
                                        <td>Yes</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Optimized images</strong>
                                        </td>
                                        <td>No</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Adapted font size</strong>
                                        </td>
                                        <td>Yes</td>
                                    </tr>
                                </table>
                            </td>
                            <td width="45%">
                                <h3>Pagespeed scores</h3>
                                <table class="table">
                                    <tr>
                                        <td><strong>Speed</strong></td>
                                        <td>59 / 100</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Usability</strong></td>
                                        <td>95 / 100</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>
    </div>
@endsection