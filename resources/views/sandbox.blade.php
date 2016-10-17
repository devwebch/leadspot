@extends('layouts.naked')

@section('title', 'Dashboard')

@section('styles')
@endsection

@section('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            }
        });

        $('.incrementBtn').click(function (e) {
            e.preventDefault();

            $.ajax({
                url: '/service/subscription/updatetest',
                method: 'POST',
                data: {type: 'contacts'}
            }).done(function (data) {
                console.log(data);
            });

        });
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 m-b-10">
            <div class="panel">
                <div class="panel-body">
                    <strong>Sandbox</strong>
                    <p>User: {{$user->id}}</p>
                    <p>Search limit: {{$quotas->search->limit}} | Search used: {{$quotas->search->used}}</p>
                    <p>Contacts limit: {{$quotas->contacts->limit}} | Contacts used: {{$quotas->contacts->used}}</p>

                    <div>
                        {{ csrf_field() }}
                        <button class="incrementBtn btn btn-default">Increment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection