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
