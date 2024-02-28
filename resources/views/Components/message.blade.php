@if($errors->count())
    <div class="message is-error">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

@if(session('message'))
    <div class="message">
        {{ session('message') }}
    </div>
@endif

@if(session('messageError'))
    <div class="message messageError">
        {{ session('messageError') }}
    </div>
@endif

@if ($message = Session::get('success'))
    <div class="alert alert-success alert-dismissible fade show alignCenter" role="alert">
        <strong>{{ $message }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-dismissible fade show alignCenter" role="alert">
        <strong>{!! $message !!}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-dismissible fade show alignCenter" role="alert">
        <strong>{!! $message !!}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
