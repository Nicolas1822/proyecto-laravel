<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datos[ 'empleados' ] = Empleado::paginate( 1 );
        return view( 'empleado.index', $datos );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view( 'empleado.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $campos = [
            'nombre'=>'required|string|max:100',
            'primerApellido'=>'required|string|max:100',
            'segundoApellido'=>'required|string|max:100',
            'correo'=>'required|email',
            'foto'=>'required|max:1000|mimes:jpeg,png,jpg'
        ];

        $mensajes = [
            'required'=>'El :attribute es requerido',
            'foto.required'=>'La foto es requerida'
        ];

        $this->validate( $request, $campos, $mensajes );

        $datosEmpleado = request()->except( '_token' );

        $datosEmpleado[ 'foto' ] = $request->file( 'foto' )->store( 'uploads', 'public' );

        Empleado::insert( $datosEmpleado );
        return redirect( 'empleado' )->with( 'mensaje', 'Empleado agregado con exito' );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $empleado = Empleado::findOrFail( $id );
        return view( 'empleado.edit', compact( 'empleado' ) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $campos = [
            'Nombre'=>'required|string|max:100',
            'PrimerApellido'=>'required|string|max:100',
            'SegundoApellido'=>'required|string|max:100',
            'Correo'=>'required|email',
            'Foto'=>'required|max:1000|mimes:jpeg,png,jpg'
        ];

        $mensajes = [
            'require'=>'El :attribute es requerido',
            'Foto.required'=>'La foto es requerida'
        ];

        //validacion de la foto
        if ($request->hasFile( 'foto' )) 
        {
            $campos = ['foto'=>'required|max:1000|mimes:jpeg,png,jpg' ];
            $mensajes = [ 'foto.required'=>'La foto es requerida' ];
        }

        $this->validate( $request, $campos, $mensajes );

        $datosEmpleado = request()->except( [ '_token', '_method' ] );

        if ( $request->hasFile( 'foto' ) ) 
        {
            $empleado = Empleado::findOrFail( $id );
            Storage::delete( 'public/' . $empleado->foto );
            $datosEmpleado[ 'foto' ] = $request->file( 'foto' )->store( 'uploads', 'public' );
        }

        Empleado::where( 'id', '=', $id )->update( $datosEmpleado );

        $empleado = Empleado::findOrFail( $id );
        // return view( 'empleado.edit', compact( 'empleado' ) );
        return redirect( 'empleado' )->with( 'mensaje', 'Empleado modificado con exito' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        //
        $empleado = Empleado::findOrFail( $id );

        if(Storage::delete( 'public/' . $empleado->foto ))
        {
            Empleado::destroy( $id );
        }

        return redirect( 'empleado' )->with( 'mensaje', 'Empleado borrado con exito' );
    }
}
