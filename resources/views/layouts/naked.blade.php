<!DOCTYPE html>
<html>
<head>
@include('layouts.partials.head')
</head>
<body class="fixed-header ">
<div class="register-container full-height sm-p-t-30">
    <div class="container-sm-height full-height">
        <div class="row row-sm-height">
            <div class="col-sm-12 col-sm-height col-middle">
                @yield('content')
            </div>
        </div>
    </div>
</div>
@include('layouts.partials.scripts')
@section('scripts')
<script>
    $(function()
    {
        $('#form-register').validate()
    })
</script>
@endsection
</body>
</html>