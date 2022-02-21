@extends('admin.layout')

@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <h1 class="h3 mb-3">Usuarios</h1>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Listado de Usuarios <a href="{{ route('admin-user-add', ['id'=> 0]) }}"><button
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
                                        <th scope="col">eMail</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($usuarios as $user)
                                        <tr>
                                            <th scope="row">{{ $user->id }}</th>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <a href="{{ route('admin-user-add', ['id'=> $user->id]) }}"><button class="btn btn-warning"><i class="fas fa-edit"></i></button></a>
                                                <a href="{{ route('admin-user-del', ['id'=> $user->id]) }}" onclick="return confirm('Esta seguro?');"><button class="btn btn-danger"><i class="fas fa-trash"></i></button></a>

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
