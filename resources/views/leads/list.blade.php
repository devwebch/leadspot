@extends('layouts.app')

@section('title', trans('breadcrumbs.leads_list'))

@section('breadcrumb')
    <li><a href="/leads/list" class="active">{{trans('breadcrumbs.leads_list')}}</a></li>
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
                    { 'bSortable': false, 'aTargets': [ 3, 6 ] }
                ]
            };
            $('#search-table').keyup(function() {
                table.fnFilter($(this).val());
            });
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
            <div class="panel-title">{{trans('breadcrumbs.leads_list')}}</div>
            <div class="pull-right hidden">
                <a href="/leads/new" class="btn btn-primary"><i class="pg-plus"></i> {{trans('lead.new_lead')}}</a>
            </div>
            <div class="pull-right">
                <div class="col-xs-12">
                    <input type="text" id="search-table" class="form-control pull-right" placeholder="{{trans('lead.search')}}">
                </div>
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
                        <th>{{trans('lead.name')}}</th>
                        <th>{{trans('lead.address')}}</th>
                        <th>{{trans('lead.url')}}</th>
                        <th>{{trans('lead.notes')}}</th>
                        <th>{{trans('lead.status_title')}}</th>
                        <th>{{trans('lead.date')}}</th>
                        <th width="120">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leads as $lead)
                    <tr>
                        <td><a href="/leads/view/{{$lead->id}}">{{$lead->name}}</a></td>
                        <td>{{$lead->address}}</td>
                        <td>
                            @if($lead->url)
                                <a href="{{$lead->url}}" target="_blank">{{substr($lead->url, 0, 50)}}</a>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($lead->notes)
                            <a href="#" class="text-success" data-toggle="popover" data-placement="top" title="{{trans('lead.notes')}}" data-content="{{$lead->notes}}">
                                <i class="fa fa-comment"></i>
                            </a>
                            @endif
                        </td>
                        <td><span class="label {{$status_classes[$lead->status]}}">{{trans($status[$lead->status])}}</span></td>
                        <td>{{date('d.m.Y', strtotime($lead->created_at))}}</td>
                        <td>
                            <div class="btn-group pull-right" role="group" aria-label="...">
                                <a href="/leads/view/{{$lead->id}}" class="btn btn-default btn-xs" title="{{trans('lead.view_lead')}}"><i class="fa fa-eye"></i></a>
                                <a href="/leads/edit/{{$lead->id}}" class="btn btn-default btn-xs" title="{{trans('lead.edit_lead')}}"><i class="fa fa-pencil"></i></a>&nbsp;
                                <a href="/leads/delete/{{$lead->id}}" class="btn btn-default btn-xs delete" title="{{trans('lead.delete_lead')}}"><i class="fa fa-times text-danger"></i></a>
                            </div>
                            <div class="clearfix"></div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL STICK UP  -->
    <div class="modal fade stick-up" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i>
                        </button>
                        <h5>{{trans('lead.delete_lead')}}</h5>
                    </div>
                    <div class="modal-body">
                        <p class="no-margin">{{trans('lead.delete_lead_warning')}}</p>
                    </div>
                    <div class="modal-footer">
                        <a href="#" class="btn btn-danger btn-cons pull-left inline continue">{{trans('lead.delete')}}</a>
                        <button type="button" class="btn btn-default btn-cons no-margin pull-left inline" data-dismiss="modal">{{trans('lead.cancel')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- END MODAL STICK UP  -->
@endsection