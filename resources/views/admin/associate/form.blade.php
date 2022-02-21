@extends('admin.layout')

@section('content')

    <main class="content">
        <div class="container-fluid p-0">

            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3>Representaciones</h3>
                </div>
                <div class="col-md-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div><br />
                    @endif
                    <div class="card">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <form action="{{ $route }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @if ($edit)
                                            @method('PUT')
                                        @endif
                                        <div class="form-group">
                                            <label for="name">Nombre</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $associate->name }}" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">URL</label>
                                            <input type="text" class="form-control" id="url" name="url"
                                                value="{{ $associate->url }}" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label>Logo</label>
                                            <input type="file" class="form-control-file" name="image">
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Orden</label>
                                            <input type="number" class="form-control" id="order" name="order" min="1"
                                                value="{{ $associate->order }}" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="content">Contenido</label>
                                            <textarea class="form-control" rows="20" placeholder="Contenido" name="content"
                                                id="content">{{ $associate->content }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </main>
    <script src="{{ asset('admin/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{ route('admin-associates.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });


    </script>
@endsection
