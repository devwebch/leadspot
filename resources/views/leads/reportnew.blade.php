<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        /*@import url('https://fonts.googleapis.com/css?family=Open+Sans');*/
    </style>

    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="css/report.css">

</head>
<body>
<table class="table">
    <tr>
        <td class="text-left">
            <img src="img/logo-leadspot.png" alt="" width="150">
        </td>
    </tr>
    <tr>
        <td class="no-padding"><hr></td>
    </tr>
</table>
<table class="table" style="margin-bottom: 30px;">
    <tr>
        <td valign="top" width="60%">
            <div class="client">
                <h1 class="title">{{$lead->name}}</h1>
                <p class="address">{{$lead->address}}</p>
            </div>
        </td>
        <td valign="top">
            <div class="contact">
                <h3 class="title">Votre contact</h3>
                <p><strong>{{$user->first_name}} {{$user->last_name}}</strong></p>
                @if($user->company)
                    <p>{{$user->company}}</p>
                @endif
                <p>{{$user->email}}</p>
            </div>
        </td>
    </tr>
</table>

<table class="table" style="margin-bottom: 30px;">
    <tr>
        <td colspan="2" valign="top">
            <table class="table">
                <tr>
                    <td class="no-padding-top no-padding-left" width="50%" valign="top">
                        <div class="score score--green">
                            <div class="icn">
                                <img src="img/icons/timer.png" height="50" width="50"/>
                            </div>
                            <h2 class="label">{{trans('report.speed')}}</h2>
                            <h3 class="pct">{{$scores->speed}}%</h3>
                        </div>
                    </td>
                    <td class="no-padding-top no-padding-right" valign="top">
                        <div class="score score--turquoise">
                            <div class="icn">
                                <img src="img/icons/iPhone.png" height="50" width="50"/>
                            </div>
                            <h2 class="label">{{trans('report.usability')}}</h2>
                            <h3 class="pct">{{$scores->usability}}%</h3>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table class="table">
    <tr>
        <td valign="top" width="50%">
            <table class="table">
                <thead>
                <tr>
                    <th colspan="2" class="header">
                        {{trans('report.obsolescence_indicators')}}
                    </th>
                </tr>
                </thead>
                <?php $count = 0; ?>
                @foreach($indicators as $key => $indicator)
                    <tr class="<?php echo ($count%2 == 0) ? '' : 'alt'; ?>">
                        <td width="70%">
                            <strong><?php echo $indicators_labels[$key]; ?></strong>
                        </td>
                        <td class="text-right">
                            <?php echo ($indicator == 0) ? trans('app.yes') : trans('app.no'); ?>
                        </td>
                    </tr>
                    <?php $count++; ?>
                @endforeach
            </table>
        </td>
        <td valign="top">
            <table class="table">
                <thead>
                <tr>
                    <th class="header">{{trans('report.general_data')}}</th>
                </tr>
                </thead>
                <tr>
                    <td><strong>{{trans('report.date')}}</strong><br>{{$lead->created_at}}</td>
                </tr>
                <tr>
                    <td><strong>{{trans('report.website')}}</strong><br>{{$lead->url}}</td>
                </tr>
                @if($website->cms)
                <tr>
                    <td><strong>{{trans('report.cms')}}</strong><br>{{$website->cms}}</td>
                </tr>
                @endif
                <tr>
                    <td><strong>{{trans('report.phone')}}</strong><br>{{$lead->phone_number}}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div style="page-break-after: always"></div>

<table class="table">
    <tr>
        <td colspan="2">
            <h1>{{trans('report.glossary')}}</h1>
        </td>
    </tr>
    <tr>
        <td width="50%">
            <strong>{{trans('report.indicators.viewport')}}</strong><br>
            {{trans('report.definition.viewport')}}
        </td>
        <td>
            <strong>{{trans('report.indicators.gzip')}}</strong><br>
            {{trans('report.definition.gzip')}}
        </td>
    </tr>
    <tr>
        <td>
            <strong>{{trans('report.indicators.minifyCss')}}</strong><br>
            {{trans('report.definition.minifyCss')}}
        </td>
        <td>
            <strong>{{trans('report.indicators.minifyJs')}}</strong><br>
            {{trans('report.definition.minifyJs')}}
        </td>
    </tr>
    <tr>
        <td>
            <strong>{{trans('report.indicators.minifyHTML')}}</strong><br>
            {{trans('report.definition.minifyHTML')}}
        </td>
        <td>
            <strong>{{trans('report.indicators.optimizeImages')}}</strong><br>
            {{trans('report.definition.optimizeImages')}}
        </td>
    </tr>
    <tr>
        <td>
            <strong>{{trans('report.indicators.fontSize')}}</strong><br>
            {{trans('report.definition.fontSize')}}
        </td>
        <td></td>
    </tr>
</table>

</body>
</html>
