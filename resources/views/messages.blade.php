{{-- @if(count($errors))
   

    @foreach ($errors as $key => $error)
        {{ $error }}
    @endforeach
@endif --}}


@if(session("success"))
    <div class="alert alert-success">
        {{ session("success") }}
    </div>
@endif

@if(session("error"))
    <div class="alert alert-danger">
        {{ session("error") }}
    </div>
@endif