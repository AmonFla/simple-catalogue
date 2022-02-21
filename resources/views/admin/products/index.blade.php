@extends('admin.layout')

@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Productos</h1>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Listado de Productos <a
                                    href="{{ route('admin-products.create') }}"><button class="btn btn-success"><i
                                            class="fas fa-plus"></i></button> </a>
                            </h5>
                        </div>
                        <div class="table-responsive">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Categoría</th>
                                        <th scope="col">Destacado</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($products as $product)
                                        <tr>
                                            <th scope="row">{{ $product->id }}</th>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->category->name }}</td>
                                            <td>
                                            @if ($product->featured) SI @else NO
                                                @endif
                                            </td>

                                            <td>
                                                <form action="{{ route('admin-products.destroy', $product->id) }}"
                                                    method="POST">
                                                    <a class="btn btn-warning"
                                                        href="{{ route('admin-products.edit', $product->id) }}"><i
                                                            class="fas fa-edit btn-warning"></i></a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger"
                                                        onclick="return confirm('Esta seguro?');"><i
                                                            class="fas fa-trash"></i></button></a>

                                                </form>

                                            </td>
                                        </tr>
                                    @endforeach



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
