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

                    <h4>Children</h4>
                    <ul>
                        @foreach($children as $child)
                            <li>{{$child->id}} - {{$child->email}}</li>
                        @endforeach
                    </ul>

                    <h4>Parent</h4>
                    @if ($parent)
                    <p>{{$parent->id}} - {{$parent->email}}</p>
                    @endif


                    <div>
                        {{ csrf_field() }}
                        <button class="incrementBtn btn btn-default">Increment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection