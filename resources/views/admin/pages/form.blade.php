@extends('admin.layout')

@section('content')

    <main class="content">
        <div class="container-fluid p-0">

            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3>Páginas</h3>
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
                                    <form action="{{ $route }}" method="post">
                                        @csrf
                                        @if ($edit)
                                            @method('PUT')
                                        @endif
                                        <div class="form-group">
                                            <label for="name">Nombre</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ $page->name }}" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="pagetypes_id">Sección</label>
                                            <select class="custom-select mb-3" name="pagetypes_id">
                                                @foreach ($type as $t)
                                                    <option value="{{ $t->id }}" @if ($page->type)  @if ($t->id==$page->type->id)
                                                        selected @endif
                                                @endif
                                                >{{ $t->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Orden</label>
                                            <input type="number" class="form-control" id="order" name="order" min="1"
                                                value="{{ $page->order }}" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="content">Contenido</label>
                                            <textarea class="form-control" rows="20" placeholder="Contenido" name="content"
                                                id="content">{{ $page->content }}</textarea>
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
    <script src="{{asset('admin/ckeditor/ckeditor.js')}}"></script>
     <script type="text/javascript">
        CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{ route('admin-pages.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });

    </script>
@endsection
