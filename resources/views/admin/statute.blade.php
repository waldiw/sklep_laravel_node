@extends('layouts.app')

@section('title', 'E-sklep Administracja')

@section('content')
    <h2>Regulamin sklepu:</h2>
    <form method="post" action="{{ Route('statute') }}" enctype="multipart/form-data">
        @csrf

        {{ method_field('PUT') }}

    <label for="statute"></label>
    <textarea class="form-control" id="statute" placeholder="regulamin" name="statute">{{ $statute }}</textarea>
        <div class="btnAddArticle">
            <button type="submit" class="btnDodaj">Zapisz regulamin <i class="fa-regular fa-square-plus" style="color: #ffffff;"></i></button>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $('#statute').summernote({
            placeholder: 'Regulamin sklepu',
            tabsize: 2,
            height: 600,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    </script>
@endsection
