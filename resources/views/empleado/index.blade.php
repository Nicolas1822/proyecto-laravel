@extends('layouts.app')

@section('content')

<div class="container">
    <div class="alert alert-success alert-dismissible" role="alert">
        @if( Session::has( 'mensaje' ) )
            {{ Session::get( 'mensaje' ) }}
        @endif

        <button type="button" class="close" data-dismiss="alert" alert-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<a href="{{ url( 'empleado/create' ) }}">Registrar nuevo empleado</a>
<table class="table table-light">
    <thead>
        <tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Primer Apellido</th>
            <th>Segundo Apellido</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
    </thead>

    <tbody>
        @foreach( $empleados as $empleado)
            <tr>
                <td>{{ $empleado->id }}</td>
                <td>
                    <img class="img-thumbnail img-fluid" src="{{ asset('storage' . '/' . $empleado->foto) }}" width="100" alt="">
                </td>
                <td>{{ $empleado->nombre }}</td>
                <td>{{ $empleado->primerApellido }}</td>
                <td>{{ $empleado->segundoApellido }}</td>
                <td>{{ $empleado->correo }}</td>
                <td>
                    <a href="{{ url( '/empleado/' . $empleado->id . '/edit') }}">
                        Editar
                    </a>

                    |

                    <form action="{{ url( '/empleado/' . $empleado->id ) }}" method="POST">
                        @csrf
                        {{ method_field( 'DELETE' ) }}

                        <input type="submit" onclick="return confirm( '¿Desea eliminar el empleado' )" value="Borrar">
                    </form>
                </td>                
            </tr>
        @endforeach
    </tbody>
</table>

{!! $empleados->links() !!}

</div>
@endsection

