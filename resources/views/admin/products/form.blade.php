@extends('admin.layout')

@section('content')

    <main class="content">
        <div class="container-fluid p-0">

            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3>Productos</h3>
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
                                                value="{{ $product->name }}" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <label for="category_id">Categoría</label>
                                            <select class="custom-select mb-3" name="category_id">
                                                @foreach ($category as $c)
                                                    <option value="{{ $c->id }}" @if ($product->category)
                                                        @if ($c->id==$product->category->id)
                                                        selected @endif
                                                @endif
                                                >{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Imágen Principal</label>
                                            <input type="file" class="form-control-file" name="image">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" name="featured" @if ($product->featured) checked @endif>
                                                <span class="form-check-label">
                                                    Producto Destacado
                                                </span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label for="content">Contenido</label>
                                            <textarea class="form-control" rows="20" placeholder="Contenido" name="content"
                                                id="content">{{ $product->content }}</textarea>
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
            filebrowserUploadUrl: "{{ route('admin-products.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });

    </script>
@endsection
