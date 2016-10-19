@extends('layouts.empty')

@section('styles')
    <style>
        body {
            color: #333;
            font-size: 13px;
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
            padding: 15px;
        }

        .no-padding {
            padding: 0;
            }
            .no-padding td {
                padding: 15px;
            }

        .bg-gray {
            background: #f6f6f6;
        }
        .bg-gray-alt {
            background: #fdfdfd;
        }
        .bg-gray-dark {
            background: #333;
            color: #fff;
            font-weight: bold;
        }
        .bg-green {
            background: #638d41;
            color: #fff;
            font-weight: bold;
        }
        .bg-blue {
            background: #3c5d74;
            color: #fff;
            font-weight: bold;
        }
        .border {
            border-bottom: 0.5px solid #c1c1c1;
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
                    <img src="img/logo-leadspot.png" alt="LeadSpot" width="150">
                </div>

                <h1>{{$lead->name}}</h1>
                <h4>{{$lead->address}}</h4>

                <table class="table" style="margin-top: 20px;" cellspacing="0">
                    <tbody>
                        <tr class="bg-gray-dark">
                            <td colspan="2" class="border">{{trans('report.general_data')}}</td>
                        </tr>
                        <tr class="">
                            <td class="border"><strong>{{trans('report.date')}}</strong></td>
                            <td class="border">{{$lead->created_at}}</td>
                        </tr>
                        <tr class="">
                            <td class="border"><strong>{{trans('report.website')}}</strong></td>
                            <td class="border">{{$lead->url}}</td>
                        </tr>
                        @if($website->cms)
                        <tr class="">
                            <td class="border"><strong>{{trans('report.cms')}}</strong></td>
                            <td class="border">{{$website->cms}}</td>
                        </tr>
                        @endif
                        <tr class="">
                            <td><strong>{{trans('report.phone')}}</strong></td>
                            <td>{{$lead->phone_number}}</td>
                        </tr>
                        <tr>
                            <td width="50%" class="no-padding" style="padding-top: 40px;">
                                <table class="table" width="98%" cellspacing="0">
                                    <tr class="bg-green">
                                        <td colspan="2">{{trans('report.obsolescence_indicators')}}</td>
                                    </tr>
                                    <?php $count = 0; ?>
                                    @foreach($indicators as $key => $indicator)
                                    <tr class="<?php echo ($count%2 == 0) ? 'bg-gray-alt' : 'bg-gray'; ?>">
                                        <td>
                                            <strong><?php echo $indicators_labels[$key]; ?></strong>
                                        </td>
                                        <td align="right">
                                            <?php echo ($indicator == 0) ? 'Yes' : 'No'; ?>
                                        </td>
                                    </tr>
                                    <?php $count++; ?>
                                    @endforeach
                                </table>
                            </td>
                            <td width="50%" class="no-padding" style="padding-top: 40px;">
                                <table class="table" width="100%" cellspacing="0">
                                    <tr class="bg-green">
                                        <td colspan="2">{{trans('report.pagespeed_scores')}}</td>
                                    </tr>
                                    <tr class="bg-gray-alt">
                                        <td><strong>{{trans('report.speed')}}</strong></td>
                                        <td align="right">{{$scores->speed}} / 100</td>
                                    </tr>
                                    <tr class="bg-gray">
                                        <td><strong>{{trans('report.usability')}}</strong></td>
                                        <td align="right">{{$scores->usability}} / 100</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="no-padding" style="padding-top: 40px;">
                                <table class="table bg-gray" width="100%" cellspacing="0">
                                    <tr class="bg-blue">
                                        <td colspan="2">{{trans('report.notes')}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">{{$lead->notes}}</td>
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