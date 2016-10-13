@extends('layouts.empty')

@section('styles')
    <style>
        body {
            color: #333;
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

        table.bordered {
            border: 1px solid #666;
        }

        table tr {

        }

        table tr td {
            vertical-align: top;
            padding: 10px;
        }

        .no-padding {
            padding: 0;
            }
            .no-padding td {
                padding: 10px;
            }

        .bg-gray {
            background: #f6f6f6;

        }
        .bg-gray-dark {
            background: #333;
            color: #fff;
            font-weight: bold;
        }
        .bg-green {
            background: #5d884b;
            color: #fff;
            font-weight: bold;
        }
        .bg-blue {
            background: #5c89a2;
            color: #fff;
            font-weight: bold;
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
                    <img src="/img/logo-leadspot.png" alt="LeadSpot" width="180">
                </div>

                <h1>{{$lead->name}}</h1>
                <h4>{{$lead->address}}</h4>

                <table class="table" style="margin-top: 20px;" cellspacing="0">
                    <tbody>
                        <tr class="bg-gray-dark">
                            <td colspan="2">General data</td>
                        </tr>
                        <tr class="bg-gray">
                            <td><strong>Website</strong></td>
                            <td>{{$lead->url}}</td>
                        </tr>
                        <tr class="bg-gray">
                            <td><strong>CMS</strong></td>
                            <td>Nom du CMS</td>
                        </tr>
                        <tr class="bg-gray">
                            <td><strong>Phone</strong></td>
                            <td>{{$lead->phone_number}}</td>
                        </tr>
                        <tr>
                            <td width="50%" class="no-padding" style="padding-top: 40px;">
                                <table class="table bg-gray" width="98%" cellspacing="0">
                                    <tr class="bg-green">
                                        <td colspan="2">Obsolescence indicators</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Responsive</strong>
                                        </td>
                                        <td align="right">Yes</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>GZIP</strong>
                                        </td>
                                        <td align="right">Yes</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Minified CSS</strong></td>
                                        <td align="right">No</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Minified JS</strong></td>
                                        <td align="right">No</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Minified HTML</strong></td>
                                        <td align="right">Yes</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Optimized images</strong>
                                        </td>
                                        <td align="right">No</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <strong>Adapted font size</strong>
                                        </td>
                                        <td align="right">Yes</td>
                                    </tr>
                                </table>
                            </td>
                            <td width="50%" class="no-padding" style="padding-top: 40px;">
                                <table class="table bg-gray" width="100%" cellspacing="0">
                                    <tr class="bg-green">
                                        <td colspan="2">Pagespeed scores</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Speed</strong></td>
                                        <td align="right">{{$scores->speed}} / 100</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Usability</strong></td>
                                        <td align="right">{{$scores->usability}} / 100</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="no-padding" style="padding-top: 40px;">
                                <table class="table bg-gray" width="100%" cellspacing="0">
                                    <tr class="bg-blue">
                                        <td colspan="2">Notes</td>
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