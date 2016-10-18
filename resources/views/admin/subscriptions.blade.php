@extends('layouts.app')

@section('title', 'Accounts')

@section('breadcrumb')
    <li><a href="/admin">Admin</a></li>
    <li><a href="/admin/accounts" class="active">Subscriptions</a></li>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('plugins/jquery-datatable/media/css/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/datatables.responsive.css')}}">
@endsection

@section('scripts')
    <script src="{{asset('plugins/jquery-datatable/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js')}}"></script>
    <script src="{{asset('plugins/jquery-datatable/media/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/datatables.responsive.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/lodash.min.js')}}"></script>

    <script>
        $(document).ready(function () {
            var table = $('#leadsTable');

            var settings = {
                "sDom": "<'table-responsive't><'row'<p i>>",
                "destroy": true,
                "scrollCollapse": true,
                "oLanguage": {
                    "sLengthMenu": "_MENU_ ",
                    "sInfo": "{{trans('pagination.showing')}} <b>_START_ {{trans('pagination.to')}} _END_</b> {{trans('pagination.of')}} _TOTAL_ {{trans('pagination.entries')}}"
                },
                "iDisplayLength": 10,
                "aoColumnDefs": [
                    { 'bSortable': false, 'aTargets': [ 6 ] }
                ]
            };

            table.dataTable(settings);

            $('[data-toggle="popover"]').popover({
                trigger: 'hover'
            })
        });
        $('.delete').click(function (e) {
            e.preventDefault();
            var $link   = $(this).attr('href');
            $('#myModal').modal();
            $('#myModal .continue').attr('href', $link);
        });
    </script>
@endsection

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">Subscriptions</div>
            <div class="pull-right hidden">
                <a href="/leads/new" class="btn btn-primary"><i class="pg-plus"></i> New lead</a>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="tooltip top" role="tooltip">
                <div class="tooltip-arrow"></div>
                <div class="tooltip-inner"></div>
            </div>
            <table id="leadsTable" class="table dataTable">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Stripe plan</th>
                        <th>Quantity</th>
                        <th>Ends at</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $subscription)
                    <tr>
                        <td>({{$subscription->user()->first()->id}}) {{$subscription->user()->first()->first_name}} {{$subscription->user()->first()->last_name}}</td>
                        <td>{{$subscription->plan()}}</td>
                        <td>{{$subscription->quantity}}</td>
                        <td>{{date('d.m.Y', strtotime($subscription->ends_at))}}</td>
                        <td>{{date('d.m.Y', strtotime($subscription->created_at))}}</td>
                        <td>{{date('d.m.Y', strtotime($subscription->updated_at))}}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="/admin/accounts/login/as/" class="btn btn-default btn-xs" title="Sign in"><i class="fa fa-sign-in"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection