@extends('layouts.app')

@section('title', 'Accounts')

@section('breadcrumb')
    <li><a href="/admin">Admin</a></li>
    <li><a href="/admin/accounts" class="active">Accounts</a></li>
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
                    "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
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
            <div class="panel-title">Accounts</div>
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
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Company</th>
                        <th>E-mail</th>
                        <th>Created at</th>
                        <th>Subscription</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($accounts as $account)
                    <tr>
                        <td>{{$account->first_name}}</td>
                        <td>{{$account->last_name}}</td>
                        <td>{{$account->company}}</td>
                        <td>{{$account->email}}</td>
                        <td>{{date('d.m.Y', strtotime($account->created_at))}}</td>
                        <td>{{$account->getSubscription()}}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="/admin/accounts/login/as/{{$account->id}}" class="btn btn-default btn-xs" title="Sign in"><i class="fa fa-sign-in"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection