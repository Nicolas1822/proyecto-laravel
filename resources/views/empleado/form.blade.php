<h2>{{ $modo }}  empleado</h2>

@if ( count( $errors ) > 0 )
<div>
    <ul class="alert alert-danger" role="alert">
        @foreach( $errors->all() as $error )
           <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<label for="nombre">Nombre</label>
<input type="text" name="nombre" value="{{ isset( $empleado->nombre ) ? $empleado->nombre : old('nombre') }}" id="nombre">

<br>

<label for="primerApellido">Primer Apellido</label>
<input type="text" name="primerApellido" value="{{ isset($empleado->primerApellido) ? $empleado->primerApellido : old('primerApellido') }}" id="primerApellido">

<br>

<label for="segundoApellido">Segundo Apellido</label>
<input type="text" name="segundoApellido" value="{{ isset($empleado->segundoApellido) ? $empleado->segundoApellido : old('segundoApellido') }}" id="segundoApellido">

<br>

<label for="correo">Correo electronico</label>
<input type="email" name="correo" value="{{ isset($empleado->correo) ? $empleado->correo : old('correo') }}" id="correo">

<br>

<label for="foto">foto</label>
@if(isset($empleado->foto))
    <img src=" {{ asset( 'storage' . '/' . $empleado->foto ) }} " width="100" alt="">
@endif
<input type="file" name="foto" id="foto">

<br>

<input type="submit" value="{{ $modo }}" id="enviar">

<br>

<a href="{{ url( 'empleado/' ) }}">regresar</a>