<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Invoice</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{asset('plugins/bootstrapv3/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link class="main-stylesheet" href="{{asset('pages/css/pages.css')}}" rel="stylesheet" type="text/css" />
    <style>
        body {
            background-image: none;
            font-size: 12px;
            color: #626262;
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 14px;
            font-weight: normal;
            letter-spacing: 0.01em;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            -webkit-font-feature-settings: "kern" 1;
            -moz-font-feature-settings: "kern" 1;
        }
        .table {
            margin-top: 5px;
        }
        .table thead tr th {
            text-transform: uppercase;
            font-weight: 600;
            font-family: 'Montserrat';
            font-size: 13px;
            padding-top: 14px;
            padding-bottom: 14px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(230, 230, 230, 0.7);
            color: rgba(44, 44, 44, 0.35);
        }
        .table thead tr th[class*='sorting_']:not([class='sorting_disabled']) {
            color: #2c2c2c;
        }
        .table thead tr th:first-child {
            padding-left: 18px !important;
        }
        .table thead tr th .btn {
            margin-top: -20px;
            margin-bottom: -20px;
        }
        .table tbody tr td {
            /*background: #fff;*/
            border-bottom: 1px solid rgba(230, 230, 230, 0.7);
            border-top: 0px;
            padding: 20px;
            font-size: 13.5px;
        }
        address{
            margin-top:15px;
        }
        h2 {
            font-size:28px;
            color:#cccccc;
        }
        .container {
            padding-top:30px;
        }
        .invoice-head td {
            padding: 0 8px;
        }
        .invoice-body{
            background-color:transparent;
        }
        .logo {
            padding-bottom: 10px;
        }
        .table th {
            vertical-align: bottom;
            font-weight: bold;
            padding: 8px;
            line-height: 20px;
            text-align: left;
        }
        .table td {
            padding: 8px;
            line-height: 20px;
            text-align: left;
            vertical-align: top;
            border-top: 1px solid #dddddd;
        }
        .well {
            margin-top: 15px;
        }
    </style>
</head>

<body>
<div class="container">
    <table style="margin-left: auto; margin-right: auto" width="550" class="table">
        <tr>
            <td width="160">
                &nbsp;
            </td>

            <!-- Organization Name / Image -->
            <td align="right">
                <strong>{{ $header or $vendor }}</strong>
            </td>
        </tr>
        <tr valign="top">
            <td style="font-size:28px;color:#cccccc;">
                    Receipt
            </td>

            <!-- Organization Name / Date -->
            <td>
                <br><br>
                <strong>To:</strong> {{ $user->email ?: $user->name }}
                <br>
                <strong>Date:</strong> {{ $invoice->date()->toFormattedDateString() }}
            </td>
        </tr>
        <tr valign="top">
            <!-- Organization Details -->
            <td style="font-size:9px;">
                {{ $vendor }}<br>
                @if (isset($street))
                    {{ $street }}<br>
                @endif
                @if (isset($location))
                    {{ $location }}<br>
                @endif
                @if (isset($phone))
                    <strong>T</strong> {{ $phone }}<br>
                @endif
                @if (isset($url))
                    <a href="{{ $url }}">{{ $url }}</a>
                @endif
            </td>
            <td>
                <!-- Invoice Info -->
                <p>
                    <strong>Product:</strong> {{ $product }}<br>
                    <strong>Invoice Number:</strong> {{ $id or $invoice->id }}<br>
                </p>

                <!-- Extra / VAT Information -->
                @if (isset($vat))
                    <p>
                        {{ $vat }}
                    </p>
                @endif

                <br><br>

                <!-- Invoice Table -->
                <table width="100%" class="table" border="0" class="table">
                    <tr>
                        <th align="left">Description</th>
                        <th align="right">Date</th>
                        <th align="right">Amount</th>
                    </tr>

                    <!-- Existing Balance -->
                    <tr>
                        <td>Starting Balance</td>
                        <td>&nbsp;</td>
                        <td>{{ $invoice->startingBalance() }}</td>
                    </tr>

                    <!-- Display The Invoice Items -->
                    @foreach ($invoice->invoiceItems() as $item)
                        <tr>
                            <td colspan="2">{{ $item->description }}</td>
                            <td>{{ $item->total() }}</td>
                        </tr>
                    @endforeach

                    <!-- Display The Subscriptions -->
                    @foreach ($invoice->subscriptions() as $subscription)
                        <tr>
                            <td>Subscription ({{ $subscription->quantity }})</td>
                            <td>
                                {{ $subscription->startDateAsCarbon()->formatLocalized('%B %e, %Y') }} -
                                {{ $subscription->endDateAsCarbon()->formatLocalized('%B %e, %Y') }}
                            </td>
                            <td>{{ $subscription->total() }}</td>
                        </tr>
                    @endforeach

                    <!-- Display The Discount -->
                    @if ($invoice->hasDiscount())
                        <tr>
                            @if ($invoice->discountIsPercentage())
                                <td>{{ $invoice->coupon() }} ({{ $invoice->percentOff() }}% Off)</td>
                            @else
                                <td>{{ $invoice->coupon() }} ({{ $invoice->amountOff() }} Off)</td>
                            @endif
                            <td>&nbsp;</td>
                            <td>-{{ $invoice->discount() }}</td>
                        </tr>
                    @endif

                    <!-- Display The Tax Amount -->
                    @if ($invoice->tax_percent)
                        <tr>
                            <td>Tax ({{ $invoice->tax_percent }}%)</td>
                            <td>&nbsp;</td>
                            <td>{{ Laravel\Cashier\Cashier::formatAmount($invoice->tax) }}</td>
                        </tr>
                    @endif

                    <!-- Display The Final Total -->
                    <tr style="border-top:2px solid #000;">
                        <td>&nbsp;</td>
                        <td style="text-align: right;"><strong>Total</strong></td>
                        <td><strong>{{ $invoice->total() }}</strong></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
