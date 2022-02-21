@extends('admin.layout')

@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Páginas</h1>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Listado de Páginas <a href="{{ route('admin-pages.create') }}"><button
                                        class="btn btn-success"><i class="fas fa-plus"></i></button> </a>
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
                                        <th scope="col">Sección</th>
                                        <th scope="col">Orden</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($pages as $page)
                                        <tr>
                                            <th scope="row">{{ $page->id }}</th>
                                            <td>{{ $page->name }}</td>
                                            <td>{{ $page->type->name }}</td>
                                            <td>{{ $page->order }}</td>
                                            <td>
                                                <form action="{{ route('admin-pages.destroy', $page->id) }}"
                                                    method="POST">
                                                    <a class="btn btn-warning" href="{{ route('admin-pages.edit', $page->id) }}"><i class="fas fa-edit btn-warning"></i></a>
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
