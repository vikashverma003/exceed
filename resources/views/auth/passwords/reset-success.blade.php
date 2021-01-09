@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Password Reset') }}</div>

                <div class="card-body">
                    @include('flash::message')

                    <a href="{{url('/')}}">Click Here</a> to visit home page.
                    <br>
                    Regards,
                    <br>
                    {{ config('app.name', 'Exceed-Media') }}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.min.js')}}"></script>

<script type="text/javascript">
    
    $(document).ready(function(){
        history.pushState(null, document.title, location.href);
        window.addEventListener('popstate', function (event)
        {
          history.pushState(null, document.title, location.href);
        });
    });

   history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };

</script>

@endsection